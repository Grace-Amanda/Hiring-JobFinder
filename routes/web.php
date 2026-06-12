<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobVacancyController;

// 1. Rute Default (Arahkan otomatis ke halaman login)
Route::get('/', function () {
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
    
    // Fitur Global (Bisa dipakai semua role)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/messages', function () { return view('chat.index'); })->name('messages.index');

    // --- AREA ADMIN ---
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', function () { return "Dashboard Admin"; });
    });

    // --- AREA APPLICANT ---
    Route::middleware('role:applicant')->prefix('applicant')->group(function () {
        Route::get('/home', function () { 
            return view('applicant.home'); 
        });
    });

    // --- AREA EMPLOYER ---
    Route::middleware('role:employer')->prefix('employer')->group(function () {
        Route::get('/dashboard', function () { 
            return view('employer.dashboard'); 
        });
        
        // CRUD Lowongan
        Route::post('/jobs', [JobVacancyController::class, 'store'])->name('jobs.store');
        Route::put('/jobs/{id}', [JobVacancyController::class, 'update'])->name('jobs.update');
        Route::delete('/jobs/{id}', [JobVacancyController::class, 'destroy'])->name('jobs.destroy');
    });
});