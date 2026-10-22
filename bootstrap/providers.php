<?php

use App\Providers\AppServiceProvider;
use App\Providers\Filament\AdminPanelProvider;
use App\Providers\Filament\ParticipantPanelProvider;

return [
    AppServiceProvider::class,
    AdminPanelProvider::class,
    ParticipantPanelProvider::class,
];
