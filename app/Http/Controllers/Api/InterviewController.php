<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Interview;
use App\Models\Swipe;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class InterviewController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'employer') {
            // FIX: employer lihat SEMUA interview miliknya kecuali cancelled
            // Ini mencakup status 'offered' (slot dikirim via chat, menunggu applicant pilih)
            // dan 'scheduled' (applicant sudah konfirmasi) agar keduanya tampil di kalender
            $interviews = Interview::with(['applicant.applicantProfile', 'jobVacancy'])
                ->where('employer_id', $user->id)
                ->whereNotIn('status', ['cancelled'])
                ->orderBy('schedule_date', 'asc')
                ->orderBy('schedule_time', 'asc')
                ->get();
        } else {
            // Applicant hanya lihat slot yang sudah 'scheduled' (dipilih) atau 'offered' (ditawarkan)
            // Tidak tampilkan yang 'cancelled'
            $interviews = Interview::with(['employer.employerProfile', 'jobVacancy'])
                ->where('applicant_id', $user->id)
                ->whereNotIn('status', ['cancelled'])
                ->orderBy('schedule_date', 'asc')
                ->orderBy('schedule_time', 'asc')
                ->get();
        }

        return response()->json(['status' => 'success', 'data' => $interviews]);
    }

    public function getMatchedCandidates()
    {
        $user = Auth::user();
        if ($user->role !== 'employer') return response()->json(['status' => 'error'], 403);

        $matched = Swipe::with(['applicant.applicantProfile', 'jobVacancy'])
            ->where('status', 'matched')
            ->where('employer_id', $user->id)
            ->get();

        return response()->json(['status' => 'success', 'data' => $matched]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'employer') return response()->json(['status' => 'error'], 403);

        $request->validate([
            'applicant_id'     => 'required',
            'job_vacancy_id'   => 'required',
            'schedule_date'    => 'required|date',
            'schedule_time'    => 'required',
            'location_or_link' => 'required|string',
            'interview_type'   => 'required|in:online,offline',
        ]);

        $interview = Interview::create([
            'employer_id'      => $user->id,
            'applicant_id'     => $request->applicant_id,
            'job_vacancy_id'   => $request->job_vacancy_id,
            'schedule_date'    => $request->schedule_date,
            'schedule_time'    => $request->schedule_time,
            'location_or_link' => $request->location_or_link,
            'interview_type'   => $request->interview_type,
            'notes'            => $request->notes ?? null,
            'status'           => 'scheduled',
        ]);

        return response()->json(['status' => 'success', 'data' => $interview], 201);
    }

    // ═══════════════════════════════════════════════════════════════
    // FITUR SINKRONISASI SLOT CHAT & KALENDER (INI YANG TADI ERROR/HILANG)
    // ═══════════════════════════════════════════════════════════════

    public function sendSlots(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'employer') return response()->json(['status' => 'error'], 403);

        $request->validate([
            'swipe_id' => 'required',
            'applicant_id' => 'required',
            'job_vacancy_id' => 'required',
            'slots' => 'required|array',
        ]);

        $interviewIds = [];
        foreach ($request->slots as $slot) {
            // Perbaiki format waktu agar matching dengan MySQL
            $formattedTime = strlen($slot['schedule_time']) == 5 ? $slot['schedule_time'] . ':00' : $slot['schedule_time'];
            
            // updateOrCreate mencegah pembuatan jadwal duplikat
            $interview = Interview::updateOrCreate(
                [
                    'employer_id' => $user->id,
                    'applicant_id' => $request->applicant_id,
                    'schedule_date' => $slot['schedule_date'],
                    'schedule_time' => $formattedTime,
                ],
                [
                    'job_vacancy_id' => $request->job_vacancy_id,
                    'interview_type' => $slot['interview_type'],
                    'location_or_link' => $slot['location_or_link'],
                    'notes' => $slot['notes'] ?? null,
                    'status' => 'offered', 
                ]
            );
            $interviewIds[] = $interview->id;
        }

        Message::create([
            'swipe_id' => $request->swipe_id,
            'sender_id' => $user->id,
            'message' => json_encode([
                'type' => 'interview_slots',
                'slot_count' => count($interviewIds),
                'interview_ids' => $interviewIds
            ])
        ]);

        return response()->json(['status' => 'success']);
    }

    public function getSlots($swipeId)
    {
        $swipe = Swipe::find($swipeId);
        if (!$swipe) return response()->json(['status' => 'error'], 404);

        $slots = Interview::where('applicant_id', Auth::id())
            ->where('employer_id', $swipe->employer_id)
            ->where('status', 'offered')
            ->get();

        return response()->json(['status' => 'success', 'data' => $slots]);
    }

    public function selectSlot(Request $request, $id)
    {
        $slot = Interview::where('id', $id)->where('applicant_id', Auth::id())->first();
        if (!$slot) return response()->json(['status' => 'error'], 404);

        $slot->update(['status' => 'scheduled']);

        Interview::where('applicant_id', Auth::id())
            ->where('employer_id', $slot->employer_id)
            ->where('id', '!=', $id)
            ->where('status', 'offered')
            ->update(['status' => 'cancelled']);

        $swipe = Swipe::where('applicant_id', Auth::id())->where('employer_id', $slot->employer_id)->first();
        if ($swipe) {
            Message::create([
                'swipe_id' => $swipe->id,
                'sender_id' => Auth::id(),
                'message' => json_encode([
                    'type' => 'slot_selected',
                    'interview_id' => $slot->id,
                    'schedule_date' => $slot->schedule_date,
                    'schedule_time' => $slot->schedule_time,
                    'interview_type' => $slot->interview_type,
                    'location_or_link' => $slot->location_or_link
                ])
            ]);
        }

        return response()->json(['status' => 'success']);
    }

    public function cancel($id)
    {
        $interview = Interview::findOrFail($id);
        $interview->update(['status' => 'cancelled']);
        return response()->json(['status' => 'success']);
    }
}