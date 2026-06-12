<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Swipe;
use Illuminate\Support\Facades\Auth;

class SwipeController extends Controller {

    public function recordSwipe(Request $request) {
        $request->validate([
            'employer_id' => 'required|exists:users,id',
            'job_vacancy_id' => 'required|exists:job_vacancies,id',
            'action' => 'required|in:like,reject' // action dari tombol swipe
        ]);

        $applicantId = Auth::id(); // Asumsi yang sedang swipe adalah Applicant

        // Cek apakah relasi swipe ini sudah pernah ada sebelumnya
        $swipe = Swipe::where('applicant_id', $applicantId)
                      ->where('job_vacancy_id', $request->job_vacancy_id)
                      ->first();

        // Logika Status
        $status = 'pending';
        if ($request->action === 'reject') {
            $status = 'rejected';
        } else {
            // Jika like, kita harus cek apakah employer sudah nge-like balik?
            // (Dalam sistem Tinder-like, matchmaking butuh 2 arah. Ini contoh dasar 1 arah dulu)
            $status = 'pending'; 
        }

        if ($swipe) {
            // Jika sudah ada (misal sebelumnya di-reject lalu di-like lagi), update statusnya
            $swipe->update(['status' => $status]);
        } else {
            // Jika belum ada, buat record baru
            Swipe::create([
                'applicant_id' => $applicantId,
                'employer_id' => $request->employer_id,
                'job_vacancy_id' => $request->job_vacancy_id,
                'status' => $status
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Swipe recorded successfully!',
            'match_status' => $status
        ], 200);
    }
}