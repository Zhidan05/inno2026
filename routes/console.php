<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('competitions:sync-status', function () {
    $count = \App\Models\Competition::syncAllStatuses();
    $this->info("Successfully synchronized {$count} competition status(es).");
})->purpose('Synchronize competition statuses based on timeline rules');

\Illuminate\Support\Facades\Schedule::command('competitions:sync-status')->hourly();

