<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Reviewer\DashboardController as ReviewerDashboardController;
use App\Http\Controllers\Reviewer\ReviewController as ReviewerReviewController;
use App\Http\Controllers\Reviewer\ReviewerNotificationController;


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

    Route::prefix('notifications')->name('notifications.')->controller(ReviewerNotificationController::class)->group(function(){
        Route::get('/', 'index')->name('index');
        Route::post('/{id}/mark-as-read','markAsRead')->name('mark-as-read');
        Route::post('/mark-all-read','markAllRead')->name('mark-all-read');
        Route::delete('/{id}','destroy')->name('destroy');
        Route::get('/unread-count','unreadCount')->name('unread-count');
    });

});