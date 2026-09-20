<?php

namespace App\Filament\Widgets;

use App\Models\Competition;
use App\Enums\UserRole;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class JudgeAssignedCompetitions extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 2;
    protected static ?string $heading = 'Assigned Competitions';

    public static function canView(): bool
    {
        $user = auth()->user();
        return $user && $user->hasRole(UserRole::JUDGE->value) && !$user->hasRole([UserRole::ADMIN->value, UserRole::MODERATOR->value]);
    }

    public function table(Table $table): Table
    {
        $user = auth()->user();
        $userId = $user ? $user->id : 0;

        return $table
            ->query(
                Competition::query()
                    ->whereHas('judges', function ($q) use ($userId) {
                        $q->where('users.id', $userId);
                    })
                    ->withCount([
                        'registrations as approved_registrations_count' => function ($q) {
                            $q->where('status', 'approved');
                        },
                        'registrations as scored_registrations_count' => function ($q) {
                            $q->where('status', 'approved')->whereNotNull('grade');
                        },
                    ])
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Competition Name')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'secondary' => 'draft',
                        'success' => fn ($state) => in_array($state, ['registration_open', 'results_published']),
                        'danger' => 'registration_closed',
                        'warning' => 'upcoming',
                        'primary' => 'ongoing',
                        'gray' => fn ($state) => in_array($state, ['completed', 'inactive']),
                    ])
                    ->formatStateUsing(fn (string $state): string => ucwords(str_replace('_', ' ', $state))),

                Tables\Columns\TextColumn::make('approved_registrations_count')
                    ->label('Participants / Entries')
                    ->formatStateUsing(fn ($state) => "{$state} Entries"),

                Tables\Columns\TextColumn::make('scoring_progress')
                    ->label('Scoring Progress')
                    ->badge()
                    ->color(fn (Competition $record): string => 
                        $record->approved_registrations_count > 0 && $record->scored_registrations_count >= $record->approved_registrations_count
                            ? 'success'
                            : ($record->scored_registrations_count > 0 ? 'warning' : 'gray')
                    )
                    ->state(fn (Competition $record): string => 
                        "Scored: {$record->scored_registrations_count} / {$record->approved_registrations_count}"
                    ),
            ])
            ->actions([
                Tables\Actions\Action::make('open')
                    ->label('Open Competition')
                    ->icon('heroicon-m-arrow-top-right-on-square')
                    ->color('primary')
                    ->url(fn (Competition $record): string => \App\Filament\Resources\CompetitionResource::getUrl('view', ['record' => $record])),
            ])
            ->emptyStateHeading('No Assigned Competitions')
            ->emptyStateDescription('You have not been assigned to any competitions yet.')
            ->emptyStateIcon('heroicon-o-trophy')
            ->paginated(false);
    }
}
