<?php

namespace App\Filament\Resources\CompetitionResource\Pages;

use App\Filament\Resources\CompetitionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewCompetition extends ViewRecord
{
    protected static string $resource = CompetitionResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Competition Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('name')
                            ->size(Infolists\Components\TextEntry\TextEntrySize::Large)
                            ->weight('bold'),
                        Infolists\Components\TextEntry::make('status')
                            ->badge()
                            ->colors([
                                'secondary' => 'draft',
                                'success' => fn ($state) => in_array($state, ['registration_open', 'results_published']),
                                'danger' => 'registration_closed',
                                'warning' => 'upcoming',
                                'primary' => 'ongoing',
                                'gray' => fn ($state) => in_array($state, ['completed', 'inactive']),
                            ]),
                        Infolists\Components\TextEntry::make('registration_type')
                            ->label('Type')
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'individual' => 'Solo',
                                'team' => 'Team',
                                'individual_or_team' => 'Solo/Team',
                                default => $state,
                            }),
                        Infolists\Components\TextEntry::make('max_team_members')
                            ->label('Max Team Members'),
                        Infolists\Components\TextEntry::make('registration_fee')
                            ->label('Registration Fee')
                            ->numeric(),
                        Infolists\Components\TextEntry::make('location'),
                        Infolists\Components\TextEntry::make('registration_open_at')
                            ->dateTime(),
                        Infolists\Components\TextEntry::make('registration_close_at')
                            ->dateTime(),
                        Infolists\Components\TextEntry::make('competition_start_at')
                            ->dateTime(),
                        Infolists\Components\TextEntry::make('competition_end_at')
                            ->dateTime(),
                    ])->columns(2),
            ]);
    }
}
