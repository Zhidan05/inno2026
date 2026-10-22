<?php

use App\Models\Competition;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('competitions:sync-status', function () {
    $count = Competition::syncAllStatuses();
    $this->info("Successfully synchronized {$count} competition status(es).");
})->purpose('Synchronize competition statuses based on timeline rules');

Schedule::command('competitions:sync-status')->hourly();
