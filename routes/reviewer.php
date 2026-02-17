<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Reviewer\DashboardController as ReviewerDashboardController;
use App\Http\Controllers\Reviewer\ReviewController as ReviewerReviewController;


// Reviewer Protected Routes
Route::middleware(['auth', 'reviewer'])->prefix('reviewer')->name('reviewer.')->group(function () {

    Route::controller(ReviewerDashboardController::class)->group(function () {
        Route::get('dashboard', 'index')->name('dashboard');
        Route::get('profile', 'profile')->name('profile');
        Route::put('profile', 'updateProfile')->name('profile.update');
    });
    
    // Review Management
    Route::controller(ReviewerReviewController::class)->group(function () {        
        Route::get('assignments', 'index')->name('assignments.index');
        Route::get('assignments/{assignment}', 'show')->name('assignments.show');
        Route::post('assignments/{assignment}/accept', 'accept')->name('assignments.accept');
        Route::post('assignments/{assignment}/decline', 'decline')->name('assignments.decline');
        Route::get('assignments/{assignment}/review', 'review')->name('assignments.review');
        Route::post('assignments/{assignment}/submit', 'submit')->name('assignments.submit');
    });

    Route::get('notifications', function() {
        // Placeholder for notifications page
        return view('reviewer.notifications');
    })->name('notifications');
});