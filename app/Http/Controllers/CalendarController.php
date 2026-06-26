<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Swipe;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    /**
     * Menampilkan halaman kalender Employer beserta daftar kandidat yang Matched.
     */
    public function index()
    {
        // Mengambil data Swipe dengan status 'matched' yang terhubung dengan employer yang sedang login
        $matches = Swipe::with(['applicant.applicantProfile'])
            ->where('employer_id', Auth::id())
            ->where('status', 'matched')
            ->get();

        return view('employer.calendar', compact('matches'));
    }
}