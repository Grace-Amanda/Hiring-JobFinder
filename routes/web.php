<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\CalendarController; // TAMBAHAN: Impor CalendarController
use Illuminate\Support\Facades\Auth;

// 1. Rute Default Pintar (Deteksi sesi login)
Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;
        if ($role === 'applicant') return redirect('/applicant/home');
        if ($role === 'employer') return redirect('/employer/dashboard');
    }
    return redirect('/login');
});

// 2. RUTE GUEST (Hanya bisa diakses jika BELUM login)
Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// 3. RUTE TERAUTENTIKASI (Hanya bisa diakses jika SUDAH login)
Route::middleware('auth')->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/messages', function () { return view('chat.message'); })->name('messages.index');

    // --- AREA ADMIN ---
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', function () { return "Dashboard Admin"; });
    });

    // --- AREA APPLICANT ---
    Route::middleware('role:applicant')->prefix('applicant')->group(function () {
        Route::get('/home', function () { return view('applicant.home'); });
        Route::get('/profile', function () { 
            $profile = \App\Models\ApplicantProfile::firstOrCreate(
                ['user_id' => Auth::id()],
                ['full_name' => Auth::user()->name, 'status' => 'active', 'rating' => 0.00]
            );
            return view('applicant.profile', compact('profile')); 
        });
        Route::get('/calendar', function () { return view('applicant.calendar'); });
    });

    // --- AREA EMPLOYER ---
    Route::middleware('role:employer')->prefix('employer')->group(function () {
        Route::get('/dashboard', function () { return view('employer.dashboard'); });
        
        Route::get('/jobs', [JobVacancyController::class, 'index'])->name('jobs.index');
        
        Route::get('/profile', function () { 
            $profile = \App\Models\EmployerProfile::firstOrCreate(
                ['user_id' => Auth::id()],
                ['company_name' => Auth::user()->name, 'status' => 'active']
            );
            return view('employer.profile', compact('profile')); 
        });

        // PERBAIKAN: Diarahkan ke CalendarController agar data looping dropdown candidate terisi sempurna
        Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
        
        Route::post('/jobs', [JobVacancyController::class, 'store'])->name('jobs.store');
        Route::put('/jobs/{id}', [JobVacancyController::class, 'update'])->name('jobs.update');
        Route::delete('/jobs/{id}', [JobVacancyController::class, 'destroy'])->name('jobs.destroy');
        Route::post('/jobs/{id}/toggle', [JobVacancyController::class, 'toggle'])->name('jobs.toggle');
    });
});