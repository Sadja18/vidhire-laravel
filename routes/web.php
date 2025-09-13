<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\ReviewerController;

// ---------------------
// Public Routes
// ---------------------
Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ---------------------
// Authenticated Routes
// ---------------------
Route::middleware('auth')->group(function () {

    // Generic Dashboard Route (fallback)
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // -----------------
    // Admin Routes
    // -----------------
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Interviews CRUD
        Route::get('/interviews/create', [AdminController::class, 'create'])->name('interviews.create');
        Route::post('/interviews', [AdminController::class, 'store'])->name('interviews.store');
        Route::get('/interviews/{interview}/edit', [AdminController::class, 'edit'])->name('interviews.edit');
        Route::put('/interviews/{interview}', [AdminController::class, 'update'])->name('interviews.update');
        Route::delete('/interviews/{interview}', [AdminController::class, 'destroy'])->name('interviews.destroy');

        // Candidate links
        Route::get('/interviews/{interview}/generate-link', [AdminController::class, 'showGenerateLinkForm'])
            ->name('interviews.generate_link');
        Route::post('/interviews/{interview}/generate-link', [AdminController::class, 'storeCandidateLink'])
            ->name('interviews.store_candidate_link');

        // Route::get('/candidate-links', [AdminController::class, 'candidateLinksDashboard'])
        //     ->name('candidate_links.dashboard');
        Route::get('admin/interviews/{interview}/candidate-links', [AdminController::class, 'candidateLinksDashboard'])
            ->name('candidate_links.dashboard');

        Route::delete('/candidate-links/{link}', [AdminController::class, 'destroyCandidateLink'])
            ->name('candidate_links.destroy');
    });

    // -----------------
    // Reviewer Routes
    // -----------------
    Route::prefix('reviewer')->name('reviewer.')->middleware('auth')->group(function () {
        Route::get('/dashboard', [ReviewerController::class, 'dashboard'])->name('dashboard');

        // Show candidate list for an interview
        Route::get('/interview/{interview}/candidates', [ReviewerController::class, 'listCandidates'])
            ->name('interview.candidates');

        // Review single candidate
        Route::get('/interview/{interview}/candidate/{candidate}/review', [ReviewerController::class, 'reviewCandidate'])
            ->name('interview.candidate.review');

        Route::post('/interview/{interview}/candidate/{candidate}/review', [ReviewerController::class, 'saveReviewCandidate'])
            ->name('interview.candidate.review.save');

        Route::get('/interview/{interview}/candidate/{candidate}/preview', [ReviewerController::class, 'previewCandidateReview'])
            ->name('interview.candidate.preview');
    });


    // -----------------
    // Candidate Routes
    // -----------------
    Route::prefix('candidate')->name('candidate.')->group(function () {
        Route::get('/dashboard', [CandidateController::class, 'dashboard'])->name('dashboard');

        // Show interview by token
        Route::get('/interview/{token}', [CandidateController::class, 'showInterview'])
            ->name('interview');

        // Handle submission of answers/videos
        Route::post('/interview/{token}/submit', [CandidateController::class, 'submitAnswers'])
            ->name('interview.submit');

        // Handle preview
        Route::get('/interview/{token}/preview', [CandidateController::class, 'previewInterview'])
            ->name('interview.preview');
    });
});
