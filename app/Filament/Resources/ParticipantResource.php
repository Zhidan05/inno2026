<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParticipantResource\Pages;
use App\Filament\Resources\ParticipantResource\RelationManagers;
use App\Models\Registration;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

class ParticipantResource extends Resource
{
    protected static ?string $model = Registration::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Participants';
    protected static ?string $navigationGroup = 'MANAGEMENT';
    
    public static function canAccess(): bool
    {
        $user = auth()->user();
        return $user && $user->hasRole([\App\Enums\UserRole::ADMIN->value, \App\Enums\UserRole::MODERATOR->value]);
    }
    protected static ?int $navigationSort = 2;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('user', function (Builder $query) {
                $query->whereHas('roles', function (Builder $query) {
                    $query->where('name', 'participant');
                });
            });
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('competition_id')
                    ->relationship('competition', 'name')
                    ->required()
                    ->disabled(fn () => !auth()->user()?->hasRole(\App\Enums\UserRole::ADMIN->value)),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Account Owner')
                    ->required()
                    ->disabled(fn () => !auth()->user()?->hasRole(\App\Enums\UserRole::ADMIN->value)),
                Forms\Components\Select::make('registration_mode')
                    ->options([
                        'solo' => 'Solo',
                        'team' => 'Team',
                    ])
                    ->required()
                    ->disabled(fn () => !auth()->user()?->hasRole(\App\Enums\UserRole::ADMIN->value)),
                Forms\Components\TextInput::make('team_name')
                    ->maxLength(255)
                    ->disabled(fn () => !auth()->user()?->hasRole(\App\Enums\UserRole::ADMIN->value)),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending Review',
                        'approved' => 'Verified',
                        'rejected' => 'Rejected',
                        'revision_required' => 'Revision Required',
                    ])
                    ->required()
                    ->disabled(fn () => !auth()->user()?->hasRole(\App\Enums\UserRole::ADMIN->value)),
                Forms\Components\TextInput::make('grade')
                    ->numeric()
                    ->step('0.01')
                    ->label('Score')
                    ->visible(fn () => auth()->user()?->hasRole(\App\Enums\UserRole::ADMIN->value)),
                Forms\Components\Textarea::make('verification_notes')
                    ->label('Verification Notes')
                    ->disabled(fn () => !auth()->user()?->hasRole(\App\Enums\UserRole::ADMIN->value)),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Participant Name')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Registration $record) => $record->user->email),
                Tables\Columns\TextColumn::make('competition.name')
                    ->label('Competition')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('registration_mode')
                    ->label('Type')
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->badge()
                    ->color('info')
                    ->sortable(),
                Tables\Columns\TextColumn::make('team_name')
                    ->label('Team Name')
                    ->searchable()
                    ->formatStateUsing(fn (?string $state, Registration $record) => $record->registration_mode === 'solo' ? 'Individual' : ($state ?? '-')),
                Tables\Columns\TextColumn::make('total_members')
                    ->label('Members')
                    ->state(fn (Registration $record) => $record->registration_mode === 'solo' ? 1 : 1 + $record->members()->count()),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                        'info' => 'revision_required',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Pending Review',
                        'approved' => 'Verified',
                        'revision_required' => 'Revision Required',
                        'rejected' => 'Rejected',
                        default => ucfirst($state),
                    }),
                Tables\Columns\TextColumn::make('proof_of_payment')
                    ->label('Payment Proof')
                    ->formatStateUsing(fn ($state) => $state ? 'Available' : 'Missing')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'danger')
                    ->url(fn (Registration $record) => $record->proof_of_payment ? asset('storage/' . $record->proof_of_payment) : null)
                    ->openUrlInNewTab(),
                Tables\Columns\TextColumn::make('ticket.ticket_code')
                    ->label('Ticket')
                    ->formatStateUsing(fn (?string $state) => $state ? 'Generated' : 'Not Generated')
                    ->badge()
                    ->color(fn (?string $state) => $state ? 'success' : 'gray'),
                Tables\Columns\TextColumn::make('grade')
                    ->label('Score')
                    ->formatStateUsing(fn (?string $state) => $state !== null ? $state : '—')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('competition_id')
                    ->relationship('competition', 'name')
                    ->label('Competition'),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending Review',
                        'approved' => 'Verified',
                        'revision_required' => 'Revision Required',
                        'rejected' => 'Rejected',
                    ]),
                Tables\Filters\SelectFilter::make('registration_mode')
                    ->options([
                        'solo' => 'Solo',
                        'team' => 'Team',
                    ])
                    ->label('Registration Mode'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn () => auth()->user()?->hasRole(\App\Enums\UserRole::ADMIN->value)),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => auth()->user()?->hasRole(\App\Enums\UserRole::ADMIN->value)),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('PARTICIPANT INFORMATION')
                    ->schema([
                        Infolists\Components\TextEntry::make('user.name')
                            ->label('Full Name'),
                        Infolists\Components\TextEntry::make('user.email')
                            ->label('Email'),
                        Infolists\Components\TextEntry::make('user.id')
                            ->label('Account ID'),
                        Infolists\Components\TextEntry::make('user.roles.name')
                            ->label('Role')
                            ->badge()
                            ->color('success')
                            ->formatStateUsing(fn () => 'Participant'),
                    ])->columns(4),

                Infolists\Components\Section::make('COMPETITION INFORMATION')
                    ->schema([
                        Infolists\Components\TextEntry::make('competition.name')
                            ->label('Competition Name'),
                        Infolists\Components\TextEntry::make('registration_mode')
                            ->label('Registration Mode')
                            ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                        Infolists\Components\TextEntry::make('team_name')
                            ->label('Team Name')
                            ->formatStateUsing(fn (?string $state, Registration $record) => $record->registration_mode === 'solo' ? '-' : ($state ?? '-')),
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Registration Date')
                            ->dateTime('d M Y, H:i'),
                        Infolists\Components\TextEntry::make('status')
                            ->label('Registration Status')
                            ->badge()
                            ->colors([
                                'warning' => 'pending',
                                'success' => 'approved',
                                'danger' => 'rejected',
                                'info' => 'revision_required',
                            ])
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'pending' => 'Pending Review',
                                'approved' => 'Verified',
                                'revision_required' => 'Revision Required',
                                'rejected' => 'Rejected',
                                default => ucfirst($state),
                            }),
                    ])->columns(5),

                Infolists\Components\Section::make('TEAM MEMBERS')
                    ->schema([
                        Infolists\Components\ViewEntry::make('members')
                            ->view('filament.infolists.entries.team-members-list')
                    ]),

                Infolists\Components\Section::make('PAYMENT')
                    ->schema([
                        Infolists\Components\TextEntry::make('proof_of_payment')
                            ->label('Payment Proof')
                            ->formatStateUsing(fn ($state) => $state ? 'Available' : 'Missing'),
                        Infolists\Components\TextEntry::make('status')
                            ->label('Verification Status')
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'pending' => 'Pending Review',
                                'approved' => 'Verified',
                                'revision_required' => 'Revision Required',
                                'rejected' => 'Rejected',
                                default => ucfirst($state),
                            }),
                    ])->columns(2),

                Infolists\Components\Section::make('VERIFICATION')
                    ->schema([
                        Infolists\Components\TextEntry::make('verifiedBy.name')
                            ->label('Verified By')
                            ->formatStateUsing(fn (?string $state) => $state ?? 'Not Verified'),
                        Infolists\Components\TextEntry::make('verified_at')
                            ->label('Verified At')
                            ->dateTime('d M Y, H:i')
                            ->formatStateUsing(fn (?string $state) => $state ?? 'Not Verified'),
                        Infolists\Components\TextEntry::make('verification_notes')
                            ->label('Moderator Notes')
                            ->formatStateUsing(fn (?string $state) => $state ?? '-'),
                    ])->columns(3),

                Infolists\Components\Section::make('TICKET')
                    ->schema([
                        Infolists\Components\TextEntry::make('ticket.ticket_code')
                            ->label('Ticket ID')
                            ->formatStateUsing(fn (?string $state) => $state ?? 'Not Generated'),
                    ])
                    ->visible(fn (Registration $record) => $record->status === 'approved'),

                Infolists\Components\Section::make('RESULT')
                    ->schema([
                        Infolists\Components\TextEntry::make('grade')
                            ->label('Score')
                            ->formatStateUsing(fn (?string $state) => $state !== null ? $state : 'Results have not been published yet.'),
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListParticipants::route('/'),
            'view' => Pages\ViewParticipant::route('/{record}'),
            'edit' => Pages\EditParticipant::route('/{record}/edit'),
        ];
    }
}
