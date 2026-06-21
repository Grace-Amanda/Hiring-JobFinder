<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Swipe;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class SwipeController extends Controller 
{
    public function recordSwipe(Request $request) 
    {
        // 1. Validasi yang fleksibel (Karena kadang ngirim employer_id, kadang applicant_id tergantung siapa yang login)
        $request->validate([
            'job_vacancy_id' => 'required|exists:job_vacancies,id',
            'action'         => 'required|in:like,reject'
        ]);

        $user = Auth::user();
        $action = $request->action;
        $job_vacancy_id = $request->job_vacancy_id;

        // 2. Tentukan ID secara dinamis berdasarkan Role
        if ($user->role === 'applicant') {
            $applicantId = $user->id;
            // Applicant harus mengirim employer_id dari frontend
            $employerId = $request->employer_id; 
        } else {
            $employerId = $user->id;
            // Employer harus mengirim applicant_id dari frontend
            $applicantId = $request->applicant_id; 
        }

        // 3. Cek apakah relasi swipe ini sudah pernah ada sebelumnya
        $swipe = Swipe::where('applicant_id', $applicantId)
                      ->where('job_vacancy_id', $job_vacancy_id)
                      ->first();

        $match_status = 'pending';

        // --- SKENARIO A: JIKA REJECT ---
        if ($action === 'reject') {
            $match_status = 'rejected';
            if ($swipe) {
                $swipe->update(['status' => 'rejected']);
            } else {
                Swipe::create([
                    'applicant_id' => $applicantId,
                    'employer_id'  => $employerId,
                    'job_vacancy_id' => $job_vacancy_id,
                    'status' => 'rejected'
                ]);
            }
        } 
        // --- SKENARIO B: JIKA LIKE ---
        else {
            if ($swipe) {
                // Jika sudah ada record, dan statusnya pending (pihak lain sudah like duluan)
                if ($swipe->status === 'pending') {
                    $swipe->update(['status' => 'matched']);
                    $match_status = 'matched';

                    // BONUS: Otomatis buat pesan pembuka saat Match!
                    Message::create([
                        'swipe_id' => $swipe->id,
                        'sender_id' => $employerId, // Seolah-olah perusahaan yang menyapa
                        'message' => 'Selamat! Profil Anda cocok dengan kriteria lowongan kami. Mari diskusikan jadwal wawancara.'
                    ]);
                } else {
                    // Jika sebelumnya rejected, biarkan tetap rejected (tidak bisa maksa match)
                    $match_status = $swipe->status;
                }
            } else {
                // Jika belum ada record sama sekali, buat baru dengan status pending
                Swipe::create([
                    'applicant_id' => $applicantId,
                    'employer_id'  => $employerId,
                    'job_vacancy_id' => $job_vacancy_id,
                    'status' => 'pending'
                ]);
                $match_status = 'pending';
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Swipe recorded successfully!',
            'match_status' => $match_status
        ], 200);
    }
}