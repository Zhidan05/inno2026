<?php

namespace App\Filament\Resources\CompetitionResource\RelationManagers;

use App\Models\Registration;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Database\Eloquent\Builder;

class RegistrationsRelationManager extends RelationManager
{
    protected static string $relationship = 'registrations';

    protected static ?string $recordTitleAttribute = 'team_name';
    
    protected static ?string $title = 'Participant / Registration History';

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('team_name')
                    ->label('Participant / Team'),
                Infolists\Components\TextEntry::make('user.name')
                    ->label('Registered By / Leader'),
                Infolists\Components\TextEntry::make('status')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => fn ($state) => in_array($state, ['rejected', 'cancelled']),
                    ]),
                Infolists\Components\TextEntry::make('grade')
                    ->label('Score / Grade'),
                Infolists\Components\TextEntry::make('submission_link')
                    ->label('Submission Link')
                    ->url(fn ($record) => $record->submission_link)
                    ->openUrlInNewTab(),
                Infolists\Components\TextEntry::make('submission_file_path')
                    ->label('Submission File')
                    ->formatStateUsing(fn ($state) => $state ? 'Download' : '-')
                    ->url(fn ($record) => $record->submission_file_path ? \Illuminate\Support\Facades\Storage::url($record->submission_file_path) : null)
                    ->openUrlInNewTab(),
                Infolists\Components\TextEntry::make('created_at')
                    ->label('Submitted At')
                    ->dateTime(),
                Infolists\Components\TextEntry::make('verification_notes')
                    ->label('Moderator Notes')
                    ->columnSpanFull(),
                Infolists\Components\RepeatableEntry::make('members')
                    ->schema([
                        Infolists\Components\TextEntry::make('name'),
                        Infolists\Components\TextEntry::make('email'),
                        Infolists\Components\TextEntry::make('phone'),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('team_name')
            ->columns([
                Tables\Columns\TextColumn::make('team_name')
                    ->label('Participant / Team')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Leader')
                    ->searchable(),
                Tables\Columns\TextColumn::make('registration_mode')
                    ->label('Type')
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => fn ($state) => in_array($state, ['rejected', 'cancelled']),
                    ]),
                Tables\Columns\TextColumn::make('grade')
                    ->label('Score')
                    ->numeric(),
                Tables\Columns\TextColumn::make('submission_link')
                    ->label('Link')
                    ->url(fn ($record) => $record->submission_link)
                    ->openUrlInNewTab()
                    ->limit(15)
                    ->visible(fn () => auth()->user()?->hasRole([\App\Enums\UserRole::ADMIN->value, \App\Enums\UserRole::JUDGE->value])),
                Tables\Columns\TextColumn::make('submission_file_path')
                    ->label('File')
                    ->formatStateUsing(fn ($state) => $state ? 'Download' : '-')
                    ->url(fn ($record) => $record->submission_file_path ? \Illuminate\Support\Facades\Storage::url($record->submission_file_path) : null)
                    ->openUrlInNewTab()
                    ->visible(fn () => auth()->user()?->hasRole([\App\Enums\UserRole::ADMIN->value, \App\Enums\UserRole::JUDGE->value])),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('View Details'),
                Tables\Actions\Action::make('score')
                    ->label('Score')
                    ->icon('heroicon-o-star')
                    ->color('primary')
                    ->form([
                        Forms\Components\TextInput::make('grade')
                            ->label('Grade / Score')
                            ->numeric()
                            ->step('0.01')
                            ->required(),
                    ])
                    ->action(function (Registration $record, array $data) {
                        $record->update([
                            'grade' => $data['grade'],
                            'scored_by' => auth()->id(),
                        ]);
                        \Filament\Notifications\Notification::make()
                            ->title('Score updated successfully')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Registration $record): bool => auth()->user()?->hasRole([\App\Enums\UserRole::ADMIN->value, \App\Enums\UserRole::JUDGE->value]) && $record->status === 'approved' && in_array($record->competition->status, ['ongoing', 'completed'])),
            ])
            ->bulkActions([
                //
            ]);
    }
}
