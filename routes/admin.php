<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminJournalsController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\AdminTagsController;
use App\Http\Controllers\Admin\VolumeController;
use App\Http\Controllers\Admin\IssueController;
use App\Http\Controllers\Admin\ReviewerController;
use App\Http\Controllers\Admin\ReviewAssignmentController;
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

    Route::resource('volumes', VolumeController::class);
    Route::post('volumes/{volume}/publish', [VolumeController::class, 'publish'])->name('volumes.publish');

    // Issue Management
    Route::resource('issues', IssueController::class);
    Route::get('volumes/{volume}/issues/create', [IssueController::class, 'createForVolume'])->name('issues.create-for-volume');
    Route::post('issues/{issue}/publish', [IssueController::class, 'publish'])->name('issues.publish');

    // Reviewer Management
    Route::resource('reviewers', ReviewerController::class);
    Route::post('reviewers/{reviewer}/toggle-status', [ReviewerController::class, 'toggleStatus'])->name('reviewers.toggle-status');

    // Review Assignments
    Route::controller(ReviewAssignmentController::class)->group(function () {
        Route::get('journals/{journal}/assign-reviewers', 'create')->name('assign-reviewers.create');
        Route::post('journals/{journal}/assign-reviewers', 'store')->name('assign-reviewers.store');
        Route::get('assignments', 'index')->name('assignments.index');
        Route::get('assignments/{assignment}', 'show')->name('assignments.show');
        Route::post('assignments/{assignment}/remind', 'sendReminder')->name('assignments.remind');
        Route::delete('assignments/{assignment}', 'destroy')->name('assignments.destroy');
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

    Route::prefix('notifications')->name('notifications.')->controller(AdminNotificationController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/mark-all-read', 'markAllRead')->name('mark-all-read');
        Route::post('/{id}/mark-as-read', 'markAsRead')->name('notifications.mark-as-read');
        Route::delete('/{id}', 'destroy')->name('notifications.destroy');
        Route::get('/unread-count', 'unreadCount')->name('notifications.unread-count');
    });
});