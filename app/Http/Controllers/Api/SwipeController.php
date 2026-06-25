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
        // 1. PERBAIKAN: Hapus 'exists:job_vacancies,id' agar dummy ID dari Employer tidak memicu error 422
        $request->validate([
            'job_vacancy_id' => 'required',
            'action'         => 'required|in:like,reject'
        ]);

        $user = Auth::user();
        $action = $request->action;
        $job_vacancy_id = $request->job_vacancy_id;

        // 2. Tentukan ID secara dinamis berdasarkan Role
        if ($user->role === 'applicant') {
            $applicantId = $user->id;
            $employerId = $request->employer_id; 
        } else {
            $employerId = $user->id;
            $applicantId = $request->applicant_id; 
        }

        // 3. PERBAIKAN UTAMA: Cari data swipe yang berstatus 'pending' antar kedua user ini 
        // agar tidak sengaja mengambil baris data sampah/uji coba lama di database
        $swipe = Swipe::where('applicant_id', $applicantId)
                      ->where('employer_id', $employerId)
                      ->where('status', 'pending')
                      ->first();

        $match_status = 'pending';
        $swipe_id     = null;  // FIX BUG #2: Tetap mempertahankan variabel milikmu

        // --- SKENARIO A: JIKA REJECT ---
        if ($action === 'reject') {
            $match_status = 'rejected';
            if ($swipe) {
                $swipe->update(['status' => 'rejected']);
                $swipe_id = $swipe->id;
            } else {
                $newSwipe = Swipe::create([
                    'applicant_id'   => $applicantId,
                    'employer_id'    => $employerId,
                    'job_vacancy_id' => $job_vacancy_id,
                    'status'         => 'rejected'
                ]);
                $swipe_id = $newSwipe->id;
            }
        } 
        // --- SKENARIO B: JIKA LIKE ---
        else {
            if ($swipe) {
                // Jika ditemukan data 'pending' dari pihak sebelah, maka sukses MATCH!
                if ($swipe->status === 'pending') {
                    
                    // Logika proteksi ID Lowongan Kerja: 
                    // Jika yang swipe kedua adalah applicant, gunakan job_vacancy_id asli dari applicant.
                    // Jika yang swipe kedua adalah employer, pertahankan job_vacancy_id asli yang sudah dibuat applicant sebelumnya.
                    $finalJobId = $user->role === 'applicant' ? $job_vacancy_id : $swipe->job_vacancy_id;

                    $swipe->update([
                        'status' => 'matched',
                        'job_vacancy_id' => $finalJobId
                    ]);
                    
                    $match_status = 'matched';
                    $swipe_id     = $swipe->id;

                    // Otomatis buat pesan pembuka di sistem chat saat Match terjadi
                    Message::create([
                        'swipe_id'  => $swipe->id,
                        'sender_id' => $employerId, // Perusahaan otomatis menyapa pelamar
                        'message'   => 'Selamat! Profil Anda cocok dengan kriteria lowongan kami. Mari diskusikan jadwal wawancara.'
                    ]);
                } else {
                    $match_status = $swipe->status;
                    $swipe_id     = $swipe->id;
                }
            } else {
                // Jika belum ada record sama sekali, buat baru dengan status pending
                $newSwipe = Swipe::create([
                    'applicant_id'   => $applicantId,
                    'employer_id'    => $employerId,
                    'job_vacancy_id' => $job_vacancy_id,
                    'status'         => 'pending'
                ]);
                $match_status = 'pending';
                $swipe_id     = $newSwipe->id;
            }
        }

        return response()->json([
            'status'       => 'success',
            'message'      => 'Swipe recorded successfully!',
            'match_status' => $match_status,
            'swipe_id'     => $swipe_id   // FIX BUG #2: kirim swipe_id ke frontend agar bisa redirect ke messages
        ], 200);
    }
}