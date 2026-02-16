<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Author\DashboardController;
use App\Http\Controllers\Author\ProfileController;
use App\Http\Controllers\Author\JournalController;
use App\Http\Controllers\Author\NotificationController;

######################################################################################
################################# Author Routes ######################################
######################################################################################

Route::middleware(['auth', 'verified'])->prefix('author')->name('author.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('index');
    
    // Journal Routes
    Route::prefix('journals')->controller(JournalController::class)->group(function () {
        Route::get('/', 'index')->name('journals.index');
        Route::get('/create', 'create')->name('journals.create');
        Route::post('/', 'store')->name('journals.store');
        Route::get('/{journal}', 'show')->name('journals.show');
        Route::get('/{journal}/edit', 'edit')->name('journals.edit');
        Route::put('/{journal}', 'update')->name('journals.update');
        Route::delete('/{journal}', 'destroy')->name('journals.destroy');
        Route::post('/{journal}/submit', 'submit')->name('journals.submit');
    });

    // Profile Routes
    Route::prefix('profile')->controller(ProfileController::class)->group(function () {
        Route::get('/', 'index')->name('profile');
        Route::put('/update', 'update')->name('profile.update');
        Route::put('/password', 'updatePassword')->name('password.update');
    });
    
    // Notification Routes
    Route::prefix('notifications')->controller(NotificationController::class)->group(function () {
        Route::get('/', 'index')->name('notifications');
        Route::post('/mark-all-read', 'markAllAsRead')->name('notifications.mark-all-read');
        Route::post('/{id}/mark-as-read', 'markAsRead')->name('notifications.mark-as-read');
        Route::get('/unread-count', 'unreadCount')->name('notifications.unread-count');
        Route::delete('/{id}', 'destroy')->name('notifications.destroy');
    });
});