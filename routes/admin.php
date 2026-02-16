<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminJournalsController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\AdminTagsController;
use App\Http\Controllers\Author\ProfileController;
use App\Http\Controllers\Admin\AdminAnnouncementController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;

######################################################################################
################################# Admin Routes #######################################
######################################################################################

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    
    // Dashboard
    Route::controller(AdminDashboardController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard');
        Route::get('/chart-data', 'getChartData')->name('chart-data');
        Route::get('/quick-stats', 'getQuickStats')->name('quick-stats');
    });
    
    // Journals Management
    Route::prefix('journals')->name('journals.')->controller(AdminJournalsController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/pending', 'pending')->name('pending');
        Route::get('/{id}', 'show')->name('show');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::post('/{id}/approve', 'approve')->name('approve');
        Route::post('/{id}/under-review', 'underReview')->name('under-review');
        Route::post('/{id}/request-revision', 'requestRevision')->name('request-revision');
        Route::post('/{id}/reject', 'reject')->name('reject');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });
    
    // Users Management
    Route::prefix('users')->name('users.')->controller(AdminUsersController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::post('/bulk-delete', 'bulkDestroy')->name('bulk-destroy');
        Route::post('/{id}/verify-email', 'verifyEmail')->name('verify-email');
        Route::post('/{id}/toggle-role', 'toggleRole')->name('toggle-role');
    });
    
    // Tags / Categories Management
    Route::prefix('tags')->name('tags.')->controller(AdminTagsController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::post('/bulk-delete', 'bulkDestroy')->name('bulk-destroy');
        Route::post('/merge', 'merge')->name('merge');
    });
    
    // Announcements Management
    Route::prefix('announcements')->name('announcements.')->controller(AdminAnnouncementController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::post('/{id}/send', 'send')->name('send');
        Route::post('/{id}/duplicate', 'duplicate')->name('duplicate');
        Route::post('/preview', 'preview')->name('preview');
    });
    
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('notifications');
    Route::get('/notifications/create-announcement', [AdminNotificationController::class, 'createAnnouncement'])->name('notifications.create-announcement');
    Route::post('/notifications/send-announcement', [AdminNotificationController::class, 'sendAnnouncement'])->name('notifications.send-announcement');
    Route::post('/notifications/mark-all-read', [AdminNotificationController::class, 'markAllRead'])->name('notifications.mark-all-read');
});