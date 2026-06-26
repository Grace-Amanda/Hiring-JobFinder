<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Interview;
use App\Models\Message;
use App\Models\Swipe;
use Illuminate\Support\Facades\Auth;

class InterviewController extends Controller
{
    /**
     * GET /api/interviews
     * Ambil semua jadwal milik user yang login.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'employer') {
            $interviews = Interview::with([
                'applicant.applicantProfile',
                'jobVacancy'
            ])
            ->where('employer_id', $user->id)
            ->orderBy('schedule_date', 'asc')
            ->orderBy('schedule_time', 'asc')
            ->get();
        } else {
            $interviews = Interview::with([
                'employer.employerProfile',
                'jobVacancy'
            ])
            ->where('applicant_id', $user->id)
            ->orderBy('schedule_date', 'asc')
            ->orderBy('schedule_time', 'asc')
            ->get();
        }

        return response()->json(['status' => 'success', 'data' => $interviews]);
    }

    /**
     * GET /api/interviews/matched-candidates
     * Daftar swipe matched milik employer — untuk dropdown buat jadwal.
     */
    public function getMatchedCandidates()
    {
        $user = Auth::user();
        if ($user->role !== 'employer') {
            return response()->json(['status' => 'error', 'message' => 'Forbidden'], 403);
        }

        $employerId = $user->id;

        $matched = Swipe::with(['applicant.applicantProfile', 'jobVacancy'])
            ->where('status', 'matched')
            ->where(function ($q) use ($employerId) {
                $q->where('employer_id', $employerId)
                  ->orWhereHas('jobVacancy', function ($jq) use ($employerId) {
                      $jq->where('employer_id', $employerId);
                  });
            })
            ->get();

        return response()->json(['status' => 'success', 'data' => $matched]);
    }

    /**
     * POST /api/interviews
     * Employer membuat jadwal interview baru.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'employer') {
            return response()->json(['status' => 'error', 'message' => 'Hanya employer yang bisa membuat jadwal.'], 403);
        }

        $request->validate([
            'applicant_id'     => 'required|exists:users,id',
            'job_vacancy_id'   => 'required|exists:job_vacancies,id',
            'schedule_date'    => 'required|date',
            'schedule_time'    => 'required',
            'location_or_link' => 'required|string|max:255',
            'interview_type'   => 'required|in:online,offline',
            'notes'            => 'nullable|string|max:1000',
        ]);

        $interview = Interview::create([
            'employer_id'      => $user->id,
            'applicant_id'     => $request->applicant_id,
            'job_vacancy_id'   => $request->job_vacancy_id,
            'schedule_date'    => $request->schedule_date,
            'schedule_time'    => $request->schedule_time,
            'location_or_link' => $request->location_or_link,
            'interview_type'   => $request->interview_type ?? 'online',
            'notes'            => $request->notes,
            'status'           => 'scheduled',
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Jadwal interview berhasil dibuat!',
            'data'    => $interview->load(['employer.employerProfile', 'applicant.applicantProfile', 'jobVacancy'])
        ], 201);
    }

    /**
     * POST /api/interviews/send-slots
     * Employer mengirim beberapa slot interview ke applicant via chat.
     *
     * Body: {
     *   swipe_id: 5,
     *   job_vacancy_id: 2,
     *   applicant_id: 10,
     *   slots: [
     *     { schedule_date: '2026-07-01', schedule_time: '09:00', location_or_link: 'https://meet.google.com/xxx', interview_type: 'online', notes: '...' },
     *     { schedule_date: '2026-07-02', schedule_time: '14:00', location_or_link: 'Kantor Jakarta', interview_type: 'offline', notes: '...' },
     *   ]
     * }
     */
    public function sendSlots(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'employer') {
            return response()->json(['status' => 'error', 'message' => 'Hanya employer yang bisa mengirim slot.'], 403);
        }

        $request->validate([
            'swipe_id'           => 'required|exists:swipes,id',
            'job_vacancy_id'     => 'required|exists:job_vacancies,id',
            'applicant_id'       => 'required|exists:users,id',
            'slots'              => 'required|array|min:1|max:5',
            'slots.*.schedule_date'    => 'required|date|after_or_equal:today',
            'slots.*.schedule_time'    => 'required',
            'slots.*.location_or_link' => 'required|string|max:255',
            'slots.*.interview_type'   => 'required|in:online,offline',
            'slots.*.notes'            => 'nullable|string|max:500',
        ]);

        // Simpan setiap slot sebagai interview dengan status 'scheduled'
        $interviewIds = [];
        foreach ($request->slots as $slot) {
            $interview = Interview::create([
                'employer_id'      => $user->id,
                'applicant_id'     => $request->applicant_id,
                'job_vacancy_id'   => $request->job_vacancy_id,
                'schedule_date'    => $slot['schedule_date'],
                'schedule_time'    => $slot['schedule_time'],
                'location_or_link' => $slot['location_or_link'],
                'interview_type'   => $slot['interview_type'],
                'notes'            => $slot['notes'] ?? null,
                'status'           => 'scheduled',
            ]);
            $interviewIds[] = $interview->id;
        }

        // Kirim pesan khusus ke chat dengan format JSON
        $messagePayload = json_encode([
            'type'          => 'interview_slots',
            'interview_ids' => $interviewIds,
            'slot_count'    => count($interviewIds),
        ]);

        $message = Message::create([
            'swipe_id'  => $request->swipe_id,
            'sender_id' => $user->id,
            'message'   => $messagePayload,
            'is_read'   => false,
        ]);

        return response()->json([
            'status'        => 'success',
            'message'       => 'Slot interview berhasil dikirim!',
            'interview_ids' => $interviewIds,
            'chat_message'  => $message,
        ]);
    }

    /**
     * GET /api/interviews/slots/{swipeId}
     * Applicant mengambil daftar slot interview yang dikirim employer untuk swipe tertentu.
     */
    public function getSlots($swipeId)
    {
        $user = Auth::user();

        // Cari semua pesan tipe interview_slots di swipe ini
        $slotMessages = Message::where('swipe_id', $swipeId)
            ->get()
            ->filter(function ($msg) {
                $decoded = json_decode($msg->message, true);
                return isset($decoded['type']) && $decoded['type'] === 'interview_slots';
            });

        if ($slotMessages->isEmpty()) {
            return response()->json(['status' => 'success', 'data' => []]);
        }

        // Kumpulkan semua interview_ids dari semua pesan slot
        $allInterviewIds = [];
        foreach ($slotMessages as $msg) {
            $decoded = json_decode($msg->message, true);
            $allInterviewIds = array_merge($allInterviewIds, $decoded['interview_ids'] ?? []);
        }

        // Ambil semua slot yang masih scheduled (belum dipilih)
        $slots = Interview::with(['jobVacancy', 'employer.employerProfile'])
            ->whereIn('id', $allInterviewIds)
            ->where('status', 'scheduled')
            ->orderBy('schedule_date', 'asc')
            ->orderBy('schedule_time', 'asc')
            ->get();

        return response()->json(['status' => 'success', 'data' => $slots]);
    }

    /**
     * POST /api/interviews/{id}/select
     * Applicant memilih satu slot interview.
     * Slot yang dipilih → 'confirmed', slot lain dari employer yg sama → 'cancelled'
     */
    public function selectSlot($id)
    {
        $user = Auth::user();
        if ($user->role !== 'applicant') {
            return response()->json(['status' => 'error', 'message' => 'Hanya applicant yang bisa memilih slot.'], 403);
        }

        $interview = Interview::where('id', $id)
            ->where('applicant_id', $user->id)
            ->where('status', 'scheduled')
            ->first();

        if (!$interview) {
            return response()->json(['status' => 'error', 'message' => 'Slot tidak ditemukan atau sudah tidak tersedia.'], 404);
        }

        // Konfirmasi slot yang dipilih
        $interview->update(['status' => 'confirmed']);

        // Batalkan slot lain dari employer yang sama untuk applicant yang sama
        Interview::where('employer_id', $interview->employer_id)
            ->where('applicant_id', $user->id)
            ->where('id', '!=', $id)
            ->where('status', 'scheduled')
            ->update(['status' => 'cancelled']);

        // Kirim pesan notifikasi ke chat
        // Cari swipe_id yang terkait
        $swipe = Swipe::where('employer_id', $interview->employer_id)
            ->where('applicant_id', $user->id)
            ->where('status', 'matched')
            ->first();

        if ($swipe) {
            $notifPayload = json_encode([
                'type'         => 'slot_selected',
                'interview_id' => $interview->id,
                'schedule_date' => $interview->schedule_date,
                'schedule_time' => $interview->schedule_time,
                'location_or_link' => $interview->location_or_link,
                'interview_type'   => $interview->interview_type,
            ]);

            Message::create([
                'swipe_id'  => $swipe->id,
                'sender_id' => $user->id,
                'message'   => $notifPayload,
                'is_read'   => false,
            ]);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Slot interview berhasil dipilih!',
            'data'    => $interview->load(['employer.employerProfile', 'jobVacancy']),
        ]);
    }

    /**
     * PUT /api/interviews/{id}
     * Employer mengedit jadwal (hanya jika masih 'scheduled').
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->role !== 'employer') {
            return response()->json(['status' => 'error', 'message' => 'Hanya employer yang bisa mengubah jadwal.'], 403);
        }

        $interview = Interview::where('id', $id)
            ->where('employer_id', $user->id)
            ->first();

        if (!$interview) {
            return response()->json(['status' => 'error', 'message' => 'Jadwal tidak ditemukan.'], 404);
        }

        if ($interview->status !== 'scheduled') {
            return response()->json(['status' => 'error', 'message' => 'Hanya jadwal berstatus "scheduled" yang bisa diubah.'], 400);
        }

        $request->validate([
            'schedule_date'    => 'sometimes|date',
            'schedule_time'    => 'sometimes',
            'location_or_link' => 'sometimes|string|max:255',
            'interview_type'   => 'sometimes|in:online,offline',
            'notes'            => 'nullable|string|max:1000',
        ]);

        $interview->update($request->only([
            'schedule_date', 'schedule_time', 'location_or_link', 'interview_type', 'notes'
        ]));

        return response()->json([
            'status'  => 'success',
            'message' => 'Jadwal berhasil diperbarui!',
            'data'    => $interview
        ]);
    }

    /**
     * POST /api/interviews/{id}/confirm
     * Applicant mengkonfirmasi kehadiran.
     */
    public function confirm($id)
    {
        $interview = Interview::where('id', $id)
            ->where('applicant_id', Auth::id())
            ->first();

        if (!$interview) {
            return response()->json(['status' => 'error', 'message' => 'Jadwal tidak ditemukan.'], 404);
        }

        if ($interview->status !== 'scheduled') {
            return response()->json(['status' => 'error', 'message' => 'Hanya jadwal berstatus "scheduled" yang bisa dikonfirmasi.'], 400);
        }

        $interview->update(['status' => 'confirmed']);

        return response()->json([
            'status'  => 'success',
            'message' => 'Interview berhasil dikonfirmasi!',
            'data'    => $interview
        ]);
    }

    /**
     * POST /api/interviews/{id}/cancel
     */
    public function cancel($id)
    {
        $user = Auth::user();

        $query = Interview::where('id', $id);
        if ($user->role === 'employer') {
            $query->where('employer_id', $user->id);
        } else {
            $query->where('applicant_id', $user->id);
        }

        $interview = $query->first();
        if (!$interview) {
            return response()->json(['status' => 'error', 'message' => 'Jadwal tidak ditemukan.'], 404);
        }

        if ($interview->status === 'completed') {
            return response()->json(['status' => 'error', 'message' => 'Jadwal yang sudah selesai tidak bisa dibatalkan.'], 400);
        }

        $interview->update(['status' => 'cancelled']);

        return response()->json([
            'status'  => 'success',
            'message' => 'Jadwal interview dibatalkan.',
            'data'    => $interview
        ]);
    }

    /**
     * POST /api/interviews/{id}/complete
     */
    public function complete($id)
    {
        $user = Auth::user();
        if ($user->role !== 'employer') {
            return response()->json(['status' => 'error', 'message' => 'Hanya employer yang bisa menandai selesai.'], 403);
        }

        $interview = Interview::where('id', $id)
            ->where('employer_id', $user->id)
            ->first();

        if (!$interview) {
            return response()->json(['status' => 'error', 'message' => 'Jadwal tidak ditemukan.'], 404);
        }

        $interview->update(['status' => 'completed']);

        return response()->json([
            'status'  => 'success',
            'message' => 'Interview ditandai selesai!',
            'data'    => $interview
        ]);
    }
}