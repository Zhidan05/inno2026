<?php

use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\CompetitionRegistrationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubmissionController;
use App\Models\Competition;
use App\Models\EventSetting;
use App\Models\Gallery;
use App\Models\MediaPartner;
use App\Models\Sponsor;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $competitions = Competition::whereNotIn('status', ['draft', 'inactive'])->get();
    $galleries = Gallery::orderBy('sort_order')->get();
    $sponsors = Sponsor::orderBy('sort_order')->get();
    $mediaPartners = MediaPartner::orderBy('sort_order')->get();
    $eventSetting = EventSetting::current();

    return view('index', compact('competitions', 'galleries', 'sponsors', 'mediaPartners', 'eventSetting'));
});

Route::view('/terms', 'terms')->name('terms');
Route::view('/privacy', 'privacy')->name('privacy');

Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
})->name('health');

Route::middleware(['auth', 'verified', 'participant'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/register/{competition:slug}', [CompetitionRegistrationController::class, 'create'])->name('competition.register');
    Route::post('/dashboard/register/{competition:slug}', [CompetitionRegistrationController::class, 'store'])->name('competition.register.store');
    Route::post('/dashboard/submissions/{registration}', [SubmissionController::class, 'store'])->name('competition.submission.store');
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
