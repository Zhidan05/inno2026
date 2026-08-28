<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Registration;

class RegistrationsRelationManager extends RelationManager
{
    protected static string $relationship = 'registrations';
    protected static ?string $title = 'My Competitions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // We typically won't create registrations from here directly given the complexity, but we can leave a minimal form or leave it read-only.
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('team_name')
            ->columns([
                Tables\Columns\TextColumn::make('competition.name')
                    ->label('Competition'),
                Tables\Columns\TextColumn::make('registration_mode')
                    ->label('Registration Mode')
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                Tables\Columns\TextColumn::make('team_name')
                    ->label('Team Name')
                    ->formatStateUsing(fn (?string $state, Registration $record) => $record->registration_mode === 'solo' ? 'Individual' : ($state ?? '-')),
                Tables\Columns\TextColumn::make('status')
                    ->label('Registration Status')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                        'info' => 'revision_required',
                    ]),
                Tables\Columns\TextColumn::make('ticket.ticket_code')
                    ->label('Ticket Status')
                    ->formatStateUsing(fn (?string $state) => $state ? 'Generated' : 'Not Generated')
                    ->badge()
                    ->color(fn (?string $state) => $state ? 'success' : 'gray'),
                Tables\Columns\TextColumn::make('grade')
                    ->label('Result Status')
                    ->formatStateUsing(fn (?string $state) => $state !== null ? "Score: {$state}" : '—'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(), // Disable creation from here
            ])
            ->actions([
                Tables\Actions\Action::make('view_participant')
                    ->label('View details')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Registration $record): string => \App\Filament\Resources\ParticipantResource::getUrl('view', ['record' => $record])),
            ])
            ->bulkActions([
                //
            ]);
    }
}
