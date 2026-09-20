<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $competitions = \App\Models\Competition::whereNotIn('status', ['draft', 'inactive'])->get();
    $galleries = \App\Models\Gallery::orderBy('sort_order')->get();
    $sponsors = \App\Models\Sponsor::orderBy('sort_order')->get();
    $mediaPartners = \App\Models\MediaPartner::orderBy('sort_order')->get();
    
    return view('index', compact('competitions', 'galleries', 'sponsors', 'mediaPartners'));
});

Route::view('/terms', 'terms')->name('terms');
Route::view('/privacy', 'privacy')->name('privacy');

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompetitionRegistrationController;
use App\Http\Controllers\CompetitionController;

Route::middleware(['auth', 'verified', 'participant'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/register/{competition:slug}', [CompetitionRegistrationController::class, 'create'])->name('competition.register');
    Route::post('/dashboard/register/{competition:slug}', [CompetitionRegistrationController::class, 'store'])->name('competition.register.store');
    Route::post('/dashboard/submissions/{registration}', [App\Http\Controllers\SubmissionController::class, 'store'])->name('competition.submission.store');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // View competition details
    Route::get('/competitions/{competition:slug}', [CompetitionController::class, 'show'])->name('competition.show');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
