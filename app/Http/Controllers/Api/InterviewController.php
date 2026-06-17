<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Interview;
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
     * Employer atau Applicant membatalkan jadwal.
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
     * Employer menandai interview sebagai selesai.
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