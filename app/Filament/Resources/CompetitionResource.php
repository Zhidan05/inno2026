<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompetitionResource\Pages;
use App\Filament\Resources\CompetitionResource\RelationManagers;
use App\Models\Competition;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Enums\UserRole;

class CompetitionResource extends Resource
{
    protected static ?string $model = Competition::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    public static function getNavigationLabel(): string
    {
        $user = auth()->user();
        if ($user && $user->hasRole(UserRole::JUDGE->value) && !$user->hasRole([UserRole::ADMIN->value, UserRole::MODERATOR->value])) {
            return 'Assigned Competitions';
        }

        return 'Competitions';
    }

    public static function getNavigationGroup(): ?string
    {
        $user = auth()->user();
        if ($user && $user->hasRole(UserRole::JUDGE->value) && !$user->hasRole([UserRole::ADMIN->value, UserRole::MODERATOR->value])) {
            return 'JUDGING';
        }

        return 'MANAGEMENT';
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }

    public static function canViewAny(): bool
    {
        $user = auth()->user();
        if (!$user) {
            return false;
        }

        if ($user->hasRole(UserRole::JUDGE->value)) {
            return true;
        }

        return static::can('viewAny');
    }

    public static function canView(Model $record): bool
    {
        $user = auth()->user();
        if (!$user) {
            return false;
        }

        if ($user->hasRole(UserRole::JUDGE->value) && !$user->hasRole([UserRole::ADMIN->value, UserRole::MODERATOR->value])) {
            return $record->judges()->where('users.id', $user->id)->exists();
        }

        return static::can('view', $record);
    }

    public static function canEdit(Model $record): bool
    {
        $user = auth()->user();
        if (!$user) {
            return false;
        }

        if ($user->hasRole(UserRole::JUDGE->value) && !$user->hasRole([UserRole::ADMIN->value, UserRole::MODERATOR->value])) {
            return false;
        }

        return static::can('update', $record);
    }

    public static function canCreate(): bool
    {
        $user = auth()->user();
        if ($user && $user->hasRole(UserRole::JUDGE->value) && !$user->hasRole([UserRole::ADMIN->value, UserRole::MODERATOR->value])) {
            return false;
        }

        return static::can('create');
    }

    public static function canDelete(Model $record): bool
    {
        $user = auth()->user();
        if ($user && $user->hasRole(UserRole::JUDGE->value) && !$user->hasRole([UserRole::ADMIN->value, UserRole::MODERATOR->value])) {
            return false;
        }

        return static::can('delete', $record);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (\Filament\Forms\Set $set, ?string $state) => $set('slug', \Illuminate\Support\Str::slug($state))),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Select::make('registration_type')
                    ->options([
                        'individual' => 'Individual (Solo only)',
                        'team' => 'Team (Team registration required)',
                        'individual_or_team' => 'Individual or Team',
                    ])
                    ->required()
                    ->default('individual_or_team')
                    ->helperText('Individual = no additional members. Team = team registration required. Individual or Team = participant can choose.'),
                Forms\Components\Select::make('submission_type')
                    ->options([
                        'none' => 'None (No submission required)',
                        'file' => 'File Only (Upload document)',
                        'link' => 'Link Only (URL submission)',
                        'both' => 'Both (File and/or Link)',
                    ])
                    ->required()
                    ->default('none'),
                Forms\Components\TextInput::make('max_team_members')
                    ->required()
                    ->numeric()
                    ->default(1)
                    ->minValue(1)
                    ->helperText('Maximum total members (including the team leader). Set to 1 for Individual.'),
                Forms\Components\TextInput::make('registration_fee')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('location')
                    ->maxLength(255),
                Forms\Components\Select::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'registration_open' => 'Registration Open',
                        'registration_closed' => 'Registration Closed',
                        'upcoming' => 'Upcoming',
                        'ongoing' => 'Ongoing',
                        'completed' => 'Completed',
                        'results_published' => 'Results Published',
                        'inactive' => 'Inactive',
                    ])
                    ->required()
                    ->default('draft'),
                Forms\Components\DateTimePicker::make('registration_open_at'),
                Forms\Components\DateTimePicker::make('registration_close_at'),
                Forms\Components\DateTimePicker::make('competition_start_at'),
                Forms\Components\DateTimePicker::make('competition_end_at'),
                Forms\Components\Select::make('judge_ids')
                    ->label('Judges')
                    ->multiple()
                    ->options(function () {
                        $users = \App\Models\User::with('roles')
                            ->whereHas('roles', fn($q) => $q->whereIn('name', [UserRole::JUDGE->value, UserRole::MODERATOR->value, UserRole::ADMIN->value]))
                            ->get();
                            
                        $judges = [];
                        $moderators = [];
                        $admins = [];
                        
                        foreach ($users as $user) {
                            $roleNames = $user->roles->pluck('name')->toArray();
                            $label = $user->name . ' — ' . collect($roleNames)->map(fn($r) => ucwords(str_replace('_', ' ', $r)))->implode(', ');
                            
                            if (in_array('judge', $roleNames)) {
                                $judges[$user->id] = $label;
                            } elseif (in_array('moderator', $roleNames)) {
                                $moderators[$user->id] = $label;
                            } else {
                                $admins[$user->id] = $label;
                            }
                        }
                        
                        $options = [];
                        if (!empty($judges)) { asort($judges); $options['Judges'] = $judges; }
                        if (!empty($moderators)) { asort($moderators); $options['Moderators'] = $moderators; }
                        if (!empty($admins)) { asort($admins); $options['Super Admins'] = $admins; }
                        
                        return $options;
                    })
                    ->afterStateHydrated(function (Forms\Components\Select $component, ?Competition $record) {
                        if ($record && $record->exists) {
                            $component->state($record->judges()->pluck('users.id')->toArray());
                        }
                    })
                    ->saveRelationshipsUsing(function (Competition $record, $state) {
                        $record->judges()->sync($state ?? []);
                    })
                    ->dehydrated(false)
                    ->preload()
                    ->columnSpanFull()
                    ->visible(fn () => auth()->user()?->hasRole(UserRole::ADMIN->value)),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('registration_type')
                    ->label('Type')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'individual' => 'Solo',
                        'team' => 'Team',
                        'individual_or_team' => 'Solo/Team',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('registrations_count')
                    ->counts('registrations')
                    ->label('Participants'),
                Tables\Columns\TextColumn::make('judges_count')
                    ->counts('judges')
                    ->label('Judges'),
                Tables\Columns\TextColumn::make('registration_fee')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'secondary' => 'draft',
                        'success' => fn ($state) => in_array($state, ['registration_open', 'results_published']),
                        'danger' => 'registration_closed',
                        'warning' => 'upcoming',
                        'primary' => 'ongoing',
                        'gray' => fn ($state) => in_array($state, ['completed', 'inactive']),
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Detail')->icon('heroicon-m-eye')->color('secondary'),
                Tables\Actions\EditAction::make()
                    ->visible(fn () => !auth()->user()?->hasRole(UserRole::JUDGE->value) || auth()->user()?->hasRole([UserRole::ADMIN->value, UserRole::MODERATOR->value])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ])->visible(fn () => !auth()->user()?->hasRole(UserRole::JUDGE->value) || auth()->user()?->hasRole([UserRole::ADMIN->value, UserRole::MODERATOR->value])),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\RegistrationsRelationManager::class,
            RelationManagers\JudgesRelationManager::class,
            RelationManagers\WinnersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompetitions::route('/'),
            'create' => Pages\CreateCompetition::route('/create'),
            'edit' => Pages\EditCompetition::route('/{record}/edit'),
            'view' => Pages\ViewCompetition::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        
        $user = auth()->user();
        if ($user && $user->hasRole(UserRole::JUDGE->value) && !$user->hasRole([UserRole::ADMIN->value, UserRole::MODERATOR->value])) {
            $query->whereHas('judges', function ($q) use ($user) {
                $q->where('users.id', $user->id);
            });
        }

        return $query;
    }
}
