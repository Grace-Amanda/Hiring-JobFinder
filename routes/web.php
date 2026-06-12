<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobVacancyController;

Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // 1. ADMIN ROUTE
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', function () { return "Sistem Database & Control Panel Admin"; });
    });

    // 2. EMPLOYER ROUTE
    Route::middleware('role:employer')->prefix('employer')->group(function () {
        Route::get('/dashboard', function () { return "Dashboard Employer - Atur Lowongan & Filter Kandidat"; });
    });

    // 3. APPLICANT ROUTE
    Route::middleware('role:applicant')->prefix('applicant')->group(function () {
        Route::get('/home', function () { return view ('applicant.home'); });
    });
});

Route::middleware('auth')->group(function () {
    // Rute Global untuk Profil (Bisa diakses Applicant & Employer, ditangani oleh logika IF di Controller)
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // --- AREA EMPLOYER ---
    Route::middleware('role:employer')->prefix('employer')->group(function () {
        Route::get('/dashboard', function () { return view ('employer.dashboard'); });
        
        // Rute CRUD Lowongan Pekerjaan
        Route::post('/jobs', [JobVacancyController::class, 'store'])->name('jobs.store');
        Route::put('/jobs/{id}', [JobVacancyController::class, 'update'])->name('jobs.update');
        Route::delete('/jobs/{id}', [JobVacancyController::class, 'destroy'])->name('jobs.destroy');
    });

    // Halaman UI Pesan (Bisa diakses Applicant & Employer)
    Route::get('/messages', function () {
        return view('chat.index');
    })->name('messages.index');
});