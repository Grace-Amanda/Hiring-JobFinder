<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Interview;
use Illuminate\Support\Facades\Auth;

class InterviewController extends Controller {
    
    // Perusahaan membuat jadwal interview
    public function store(Request $request) {
        if (Auth::user()->role !== 'employer') {
            return response()->json(['message' => 'Hanya perusahaan yang bisa membuat jadwal.'], 403);
        }

        $request->validate([
            'applicant_id' => 'required|exists:users,id',
            'job_vacancy_id' => 'required|exists:job_vacancies,id',
            'schedule_date' => 'required|date',
            'schedule_time' => 'required',
            'location_or_link' => 'required|string'
        ]);

        $interview = Interview::create([
            'employer_id' => Auth::id(),
            'applicant_id' => $request->applicant_id,
            'job_id' => $request->job_vacancy_id,
            'schedule_date' => $request->schedule_date,
            'schedule_time' => $request->schedule_time,
            'location_or_link' => $request->location_or_link,
            'status' => 'scheduled'
        ]);

        return response()->json(['status' => 'success', 'data' => $interview], 200);
    }
}
