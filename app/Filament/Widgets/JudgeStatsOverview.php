<?php

namespace App\Filament\Widgets;

use App\Models\Registration;
use App\Models\Competition;
use App\Enums\UserRole;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class JudgeStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        $user = auth()->user();
        return $user && $user->hasRole(UserRole::JUDGE->value) && !$user->hasRole([UserRole::ADMIN->value, UserRole::MODERATOR->value]);
    }

    protected function getStats(): array
    {
        $user = auth()->user();
        if (!$user) {
            return [];
        }

        $assignedCompetitionIds = $user->judgedCompetitions()->pluck('competitions.id');

        $assignedCount = $assignedCompetitionIds->count();

        $approvedRegistrations = Registration::whereIn('competition_id', $assignedCompetitionIds)
            ->where('status', 'approved');

        $totalApproved = (clone $approvedRegistrations)->count();
        $totalScored = (clone $approvedRegistrations)->whereNotNull('grade')->count();

        return [
            Stat::make('Welcome', $user->name)
                ->description('Assigned Judge')
                ->descriptionIcon('heroicon-m-user-circle')
                ->color('primary'),

            Stat::make('Assigned Competitions', $assignedCount)
                ->description('Competitions to evaluate')
                ->descriptionIcon('heroicon-m-trophy')
                ->color('warning'),

            Stat::make('Total Approved Entries', $totalApproved)
                ->description('Entries eligible for scoring')
                ->descriptionIcon('heroicon-m-clipboard-document-check')
                ->color('info'),

            Stat::make('Scoring Progress', "{$totalScored} / {$totalApproved}")
                ->description($totalApproved > 0 && $totalScored >= $totalApproved ? 'All entries scored' : 'Scoring in progress')
                ->descriptionIcon('heroicon-m-star')
                ->color($totalApproved > 0 && $totalScored >= $totalApproved ? 'success' : 'primary'),
        ];
    }
}
