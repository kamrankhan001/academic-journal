<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminAuthController;

######################################################################################
################################# Authentication Routes ##############################
######################################################################################

Route::prefix('auth')->controller(AuthController::class)->group(function () {

    Route::middleware('guest')->group(function () {
        // Login routes
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'login');

        // Register routes
        Route::get('/register', 'showRegisterForm')->name('register');
        Route::post('/register', 'register');

        // Forgot password routes
        Route::get('/forgot-password', 'showForgotForm')->name('password.request');
        Route::post('/forgot-password', 'sendResetLink')->name('password.email');

        // Reset password routes
        Route::get('/reset-password/{token}', 'showResetForm')->name('password.reset');
        Route::post('/reset-password', 'resetPassword')->name('password.update');

        // Admin Login routes
        Route::prefix('admin')->name('admin.')->controller(AdminAuthController::class)->group(function () {
            Route::get('/login', 'index')->name('login');
            Route::post('/login', 'login')->name('login.submit');
        });
    });

    // Logout
    Route::post('/logout', 'logout')->name('logout');
});

Route::controller(AuthController::class)->group(function () {
    // Email Verification Routes
    Route::get('/email/verify', 'showVerificationNotice')->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', 'verifyEmail')->name('verification.verify');
    Route::post('/email/resend', 'resendVerification')->name('verification.resend');
});

