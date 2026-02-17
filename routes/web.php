<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeneralJournalController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\NewsletterController;

Route::redirect('/', '/home');

Route::controller(GeneralJournalController::class)->group(function () {
    Route::get('/journals',     'index')->name('journals');
    Route::get('/archives',     'archives')->name('archives');
    Route::get('/journal/{slug}', 'showJournal')->name('journal.show');
    });

Route::controller(PageController::class)->group(function () {
    Route::get('/home', 'home')->name('home');
    Route::get('/about', 'about')->name('about');
    Route::get('/contact', 'contact')->name('contact');

    Route::get('/current-issue', 'currentIssue')->name('current-issue');
    Route::get('/announcements', 'announcements')->name('announcements');
    Route::get('/authors-guidelines', 'guidelines')->name('guidelines');
    Route::get('/editorial-policies', 'editorialPolicy')->name('editorial-policy');
    Route::get('/journal-policies', 'journalPolicies')->name('journal-policies');
    Route::get('/reviewers', 'reviewers')->name('reviewers');
    Route::get('/editorial-team', 'editorialTeam')->name('editorial-team');



    Route::get('/privacy', 'privacy')->name('privacy');
    Route::get('/terms', 'terms')->name('terms');
    Route::get('/cookies', 'cookies')->name('cookies');

    // Contact form submission
    Route::post('/contact', 'submitContact')->name('contact.submit');
});

Route::prefix('newsletter')->name('newsletter.')->controller(NewsletterController::class)->group(function () {
    Route::post('/subscribe', 'subscribe')->name('subscribe');
    Route::get('/verify/{token}', 'verify')->name('verify');
    Route::get('/unsubscribe/{email}/{token?}', 'unsubscribe')->name('unsubscribe');
});


require __DIR__ . '/auth.php';
require __DIR__ . '/author.php';
require __DIR__ . '/admin.php';