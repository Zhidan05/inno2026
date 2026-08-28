<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Registration;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->description('Total registered accounts')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Total Participants', User::role('participant')->count())
                ->description('Users with participant role')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),

            Stat::make('Total Competition Registrations', Registration::count())
                ->description('Total submissions')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('info'),

            Stat::make('Pending Verifications', Registration::whereIn('status', ['pending', 'revision_required'])->count())
                ->description('Requires moderator review')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Verified Participants', Registration::where('status', 'approved')->count())
                ->description('Approved registrations')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),
        ];
    }
}
