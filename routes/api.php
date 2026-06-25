<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\SwipeController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\InterviewController;

// Middleware 'auth:sanctum' memastikan hanya request yang membawa token yang diizinkan masuk
Route::middleware('auth:sanctum')->group(function () {
    
    // Endpoint API untuk mencari lowongan & kandidat
    Route::get('/jobs/search', [SearchController::class, 'searchJobs']);
    Route::get('/applicants/search', [SearchController::class, 'searchApplicants']);

    // Endpoint API untuk merekam swipe card
    Route::post('/swipe', [SwipeController::class, 'recordSwipe']);
    
    // Rute Chat & Connections
    Route::get('/connections', [ChatController::class, 'getConnections']);
    Route::get('/messages/{swipeId}', [ChatController::class, 'getMessages']);
    Route::post('/messages', [ChatController::class, 'sendMessage']);

    // Rute Kalender Interview
    Route::get('/interviews', [InterviewController::class, 'index']);
    Route::get('/interviews/matched-candidates', [InterviewController::class, 'getMatchedCandidates']);

    Route::post('/interviews', [InterviewController::class, 'store']);

    // Untuk Swipe
    Route::middleware('auth:sanctum')->post('/swipe', [SwipeController::class, 'recordSwipe']);
    Route::post('/interviews/{id}/confirm', [InterviewController::class, 'confirm']);
    Route::post('/interviews/{id}/cancel', [InterviewController::class, 'cancel']);
    Route::post('/interviews/{id}/complete', [InterviewController::class, 'complete']);
});

