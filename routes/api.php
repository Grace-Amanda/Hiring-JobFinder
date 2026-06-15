<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\SwipeController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\InterviewController;

// Middleware 'auth:sanctum' memastikan hanya request yang membawa token yang diizinkan masuk
Route::middleware('auth:sanctum')->group(function () {
    
    // Endpoint API untuk mencari lowongan (Asinkronus)
    Route::get('/jobs/search', [SearchController::class, 'searchJobs']);

    // Endpoint API untuk merekam swipe card
    Route::post('/swipe', [SwipeController::class, 'recordSwipe']);
    
    // Rute Message & Connections
    Route::get('/connections', [MessageController::class, 'getConnections']);
    Route::get('/messages/{swipeId}', [MessageController::class, 'getMessages']);
    Route::post('/messages', [MessageController::class, 'sendMessage']);

    // Rute Kalender Interview
    Route::post('/interviews', [InterviewController::class, 'store']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/jobs/search', [SearchController::class, 'searchJobs']);
    Route::post('/swipe', [SwipeController::class, 'recordSwipe']);
    
    // Rute Baru: API Filter Kandidat untuk Employer
    Route::get('/applicants/search', [SearchController::class, 'searchApplicants']);
});