<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobVacancy;

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
        $keyword = $request->query('keyword');

        // Mengambil data profil applicant yang statusnya sedang aktif mencari kerja
        $query = \App\Models\ApplicantProfile::with('user')->where('status', 'active_searching');

        // Jika ada ketikan di kolom pencarian, filter berdasarkan nama, pendidikan, atau riwayat kerja
        if ($keyword) {
            $query->where(function($q) use ($keyword) {
                $q->where('full_name', 'LIKE', '%' . $keyword . '%')
                  ->orWhere('education', 'LIKE', '%' . $keyword . '%')
                  ->orWhere('job_history', 'LIKE', '%' . $keyword . '%');
            });
        }

        $applicants = $query->get();

        return response()->json([
            'status' => 'success',
            'data' => $applicants
        ], 200);
    }
}
