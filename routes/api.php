<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\SwipeController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\InterviewController;
use App\Http\Controllers\Api\MessageController;

Route::middleware('auth:sanctum')->group(function () {

    // ── Search ──────────────────────────────────────────────────────────
    Route::get('/jobs/search',       [SearchController::class, 'searchJobs']);
    Route::get('/applicants/search', [SearchController::class, 'searchApplicants']);

    // ── Swipe ────────────────────────────────────────────────────────────
    Route::post('/swipe', [SwipeController::class, 'recordSwipe']);

    // ── Chat & Connections ───────────────────────────────────────────────
    Route::get('/connections',        [ChatController::class, 'getConnections']);
    Route::get('/messages/{swipeId}', [ChatController::class, 'getMessages']);
    Route::post('/messages',          [ChatController::class, 'sendMessage']);

    // ── Interview Slots (BARU) ───────────────────────────────────────────
    // PENTING: Route statis harus di atas route dinamis ({id})
    Route::post('/interviews/send-slots',        [InterviewController::class, 'sendSlots']);
    Route::get('/interviews/slots/{swipeId}',    [InterviewController::class, 'getSlots']);
    Route::post('/interviews/{id}/select',       [InterviewController::class, 'selectSlot']);

    // ── Kalender Interview ───────────────────────────────────────────────
    Route::get('/interviews',                    [InterviewController::class, 'index']);
    Route::get('/interviews/matched-candidates', [InterviewController::class, 'getMatchedCandidates']);
    Route::post('/interviews',                   [InterviewController::class, 'store']);
    Route::put('/interviews/{id}',               [InterviewController::class, 'update']);
    Route::post('/interviews/{id}/confirm',      [InterviewController::class, 'confirm']);
    Route::post('/interviews/{id}/cancel',       [InterviewController::class, 'cancel']);
    Route::post('/interviews/{id}/complete',     [InterviewController::class, 'complete']);
});