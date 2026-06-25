<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobVacancy;
use App\Models\ApplicantProfile;
use App\Models\Swipe;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller {
    
    public function searchJobs(Request $request) {
        $keyword = $request->query('keyword');

        // Jika keyword kosong, ambil semua lowongan aktif. Jika ada, filter judulnya.
        if ($keyword) {
            $jobs = JobVacancy::with('employer.employerProfile')
                ->where('is_active', true)
                ->where('title', 'LIKE', '%' . $keyword . '%')
                ->get();
        } else {
            $jobs = JobVacancy::with('employer.employerProfile')
                ->where('is_active', true)
                ->get();
        }

        // Kembalikan dalam format JSON dengan status HTTP 200 (OK)
        return response()->json([
            'status' => 'success',
            'data' => $jobs
        ], 200);
    }

    // Fungsi khusus Employer untuk memfilter Applicant
    public function searchApplicants(Request $request) {
        $keyword  = $request->query('keyword');
        $location = $request->query('location');
        $rating   = $request->query('rating');
        $education = $request->query('education');

        // Mengambil data profil applicant yang statusnya sedang aktif mencari kerja
        $query = ApplicantProfile::with('user')->where('status', 'active_searching');

        // Filter berdasarkan keyword (nama, pendidikan, riwayat kerja)
        if ($keyword) {
            $query->where(function($q) use ($keyword) {
                $q->where('full_name', 'LIKE', '%' . $keyword . '%')
                  ->orWhere('education', 'LIKE', '%' . $keyword . '%')
                  ->orWhere('job_history', 'LIKE', '%' . $keyword . '%');
            });
        }

        // Filter berdasarkan lokasi
        if ($location) {
            $query->where('location_applicant', 'LIKE', '%' . $location . '%');
        }

        // Filter berdasarkan rating minimum
        if ($rating) {
            $query->where('rating', '>=', $rating);
        }

        // Filter berdasarkan pendidikan
        if ($education) {
            $query->where('education', 'LIKE', '%' . $education . '%');
        }

        $applicants = $query->get();

        // FIX BUG #4: Tambahkan job_vacancy_id ke setiap data kandidat
        // agar employer dashboard bisa mengirim job_vacancy_id yang benar ke /api/swipe.
        // Caranya: cari swipe yang sudah ada antara employer ini & kandidat tersebut,
        // jika ada ambil job_vacancy_id-nya. Jika belum ada, cari lowongan aktif employer ini.
        $employerId = Auth::id();

        // Ambil semua lowongan aktif employer ini (untuk fallback job_vacancy_id)
        $employerJobs = JobVacancy::where('employer_id', $employerId)
            ->where('is_active', true)
            ->pluck('id');
        $defaultJobId = $employerJobs->first(); // Ambil lowongan pertama sebagai default

        // Ambil semua swipe existing milik employer ini (untuk cek apakah sudah ada swipe)
        $existingSwipes = Swipe::where('employer_id', $employerId)
            ->whereIn('applicant_id', $applicants->pluck('user_id'))
            ->get()
            ->keyBy('applicant_id');

        // Tambahkan field job_vacancy_id ke setiap kandidat
        $applicants = $applicants->map(function($applicant) use ($existingSwipes, $defaultJobId) {
            // Jika sudah ada swipe, pakai job_vacancy_id dari swipe itu
            if ($existingSwipes->has($applicant->user_id)) {
                $applicant->job_vacancy_id = $existingSwipes[$applicant->user_id]->job_vacancy_id;
            } else {
                // Jika belum, pakai lowongan aktif pertama milik employer ini
                $applicant->job_vacancy_id = $defaultJobId;
            }
            return $applicant;
        });

        return response()->json([
            'status' => 'success',
            'data' => $applicants
        ], 200);
    }
}