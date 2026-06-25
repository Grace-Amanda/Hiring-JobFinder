<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\SwipeController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\InterviewController;

/*
|--------------------------------------------------------------------------
| FIX: Route ini sudah dibersihkan dari duplikat dan diurutkan dengan benar.
|
| BUG LAMA: Ada dua Route::post('/swipe') yang duplikat — ini menyebabkan
|           request kedua bisa diabaikan oleh Laravel.
|
| BUG LAMA: Route GET /interviews/matched-candidates harus didefinisikan
|           SEBELUM /interviews/{id} (jika ada), karena Laravel membaca
|           route dari atas ke bawah. Jika {id} di atas, string
|           "matched-candidates" akan ditangkap sebagai {id}.
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // ── Search ──────────────────────────────────────────────────────────
    Route::get('/jobs/search',       [SearchController::class, 'searchJobs']);
    Route::get('/applicants/search', [SearchController::class, 'searchApplicants']);

    // ── Swipe (hanya satu, duplikat dihapus) ────────────────────────────
    Route::post('/swipe', [SwipeController::class, 'recordSwipe']);

    // ── Chat & Connections ───────────────────────────────────────────────
    Route::get('/connections',          [ChatController::class, 'getConnections']);
    Route::get('/messages/{swipeId}',   [ChatController::class, 'getMessages']);
    Route::post('/messages',            [ChatController::class, 'sendMessage']);

    // ── Kalender Interview ───────────────────────────────────────────────
    // PENTING: Route statis (matched-candidates) HARUS di atas route dinamis ({id})
    Route::get('/interviews',                        [InterviewController::class, 'index']);
    Route::get('/interviews/matched-candidates',     [InterviewController::class, 'getMatchedCandidates']);
    Route::post('/interviews',                       [InterviewController::class, 'store']);
    Route::put('/interviews/{id}',                   [InterviewController::class, 'update']);
    Route::post('/interviews/{id}/confirm',          [InterviewController::class, 'confirm']);
    Route::post('/interviews/{id}/cancel',           [InterviewController::class, 'cancel']);
    Route::post('/interviews/{id}/complete',         [InterviewController::class, 'complete']);
});