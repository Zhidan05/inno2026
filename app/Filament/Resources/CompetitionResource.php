<?php

namespace App\Filament\Resources;

use App\Enums\UserRole;
use App\Filament\Resources\CompetitionResource\Pages;
use App\Filament\Resources\CompetitionResource\RelationManagers;
use App\Models\Competition;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CompetitionResource extends Resource
{
    protected static ?string $model = Competition::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    public static function getNavigationLabel(): string
    {
        $user = auth()->user();
        if ($user && $user->hasRole(UserRole::JUDGE->value) && ! $user->hasRole([UserRole::ADMIN->value, UserRole::MODERATOR->value])) {
            return 'Assigned Competitions';
        }

        return 'Competitions';
    }

    public static function getNavigationGroup(): ?string
    {
        $user = auth()->user();
        if ($user && $user->hasRole(UserRole::JUDGE->value) && ! $user->hasRole([UserRole::ADMIN->value, UserRole::MODERATOR->value])) {
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
        if (! $user) {
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
        if (! $user) {
            return false;
        }

        if ($user->hasRole(UserRole::JUDGE->value) && ! $user->hasRole([UserRole::ADMIN->value, UserRole::MODERATOR->value])) {
            return $record->judges()->where('users.id', $user->id)->exists();
        }

        return static::can('view', $record);
    }

    public static function canEdit(Model $record): bool
    {
        $user = auth()->user();
        if (! $user) {
            return false;
        }

        if ($user->hasRole(UserRole::JUDGE->value) && ! $user->hasRole([UserRole::ADMIN->value, UserRole::MODERATOR->value])) {
            return false;
        }

        return static::can('update', $record);
    }

    public static function canCreate(): bool
    {
        $user = auth()->user();
        if ($user && $user->hasRole(UserRole::JUDGE->value) && ! $user->hasRole([UserRole::ADMIN->value, UserRole::MODERATOR->value])) {
            return false;
        }

        return static::can('create');
    }

    public static function canDelete(Model $record): bool
    {
        $user = auth()->user();
        if ($user && $user->hasRole(UserRole::JUDGE->value) && ! $user->hasRole([UserRole::ADMIN->value, UserRole::MODERATOR->value])) {
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
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
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
                        'extended' => 'Extended',
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
                Forms\Components\DateTimePicker::make('extended_registration_close_at')
                    ->label('Extended Registration Closes At')
                    ->helperText('Optional. Overrides original registration deadline and sets status to Extended until this deadline passes.')
                    ->nullable(),
                Forms\Components\DateTimePicker::make('competition_start_at'),
                Forms\Components\DateTimePicker::make('competition_end_at'),
                Forms\Components\Select::make('judge_ids')
                    ->label('Judges')
                    ->multiple()
                    ->options(function () {
                        $users = User::with('roles')
                            ->whereHas('roles', fn ($q) => $q->whereIn('name', [UserRole::JUDGE->value, UserRole::MODERATOR->value, UserRole::ADMIN->value]))
                            ->get();

                        $judges = [];
                        $moderators = [];
                        $admins = [];

                        foreach ($users as $user) {
                            $roleNames = $user->roles->pluck('name')->toArray();
                            $label = $user->name.' - '.collect($roleNames)->map(fn ($r) => ucwords(str_replace('_', ' ', $r)))->implode(', ');

                            if (in_array('judge', $roleNames)) {
                                $judges[$user->id] = $label;
                            } elseif (in_array('moderator', $roleNames)) {
                                $moderators[$user->id] = $label;
                            } else {
                                $admins[$user->id] = $label;
                            }
                        }

                        $options = [];
                        if (! empty($judges)) {
                            asort($judges);
                            $options['Judges'] = $judges;
                        }
                        if (! empty($moderators)) {
                            asort($moderators);
                            $options['Moderators'] = $moderators;
                        }
                        if (! empty($admins)) {
                            asort($admins);
                            $options['Super Admins'] = $admins;
                        }

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
                    ->formatStateUsing(function (string $state, Competition $record): string {
                        if ($record->isExtended()) {
                            return $record->extended_status_label;
                        }

                        return match ($state) {
                            'extended' => $record->extended_status_label ?: 'Extended',
                            'registration_open' => 'Registration Open',
                            'registration_closed' => 'Registration Closed',
                            'upcoming' => 'Upcoming',
                            'ongoing' => 'Ongoing',
                            'completed' => 'Completed',
                            'results_published' => 'Results Published',
                            'draft' => 'Draft',
                            'inactive' => 'Inactive',
                            default => ucfirst(str_replace('_', ' ', $state)),
                        };
                    })
                    ->colors([
                        'warning' => fn ($state, $record) => $record->isExtended() || $state === 'extended' || $state === 'upcoming',
                        'secondary' => 'draft',
                        'success' => fn ($state, $record) => ! $record->isExtended() && in_array($state, ['registration_open', 'results_published']),
                        'danger' => 'registration_closed',
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
                Tables\Actions\Action::make('extend_registration')
                    ->label('Extend Registration')
                    ->icon('heroicon-o-calendar-days')
                    ->color('warning')
                    ->visible(fn () => ! auth()->user()?->hasRole(UserRole::JUDGE->value) || auth()->user()?->hasRole([UserRole::ADMIN->value, UserRole::MODERATOR->value]))
                    ->modalHeading(fn (Competition $record) => "Extend Registration: {$record->name}")
                    ->modalDescription('Set a new deadline for this competition. The status will automatically display as Extended on the website and registration will reopen.')
                    ->modalSubmitActionLabel('Save Extension')
                    ->form([
                        Forms\Components\DateTimePicker::make('extended_registration_close_at')
                            ->label('New Extended Registration Deadline')
                            ->required()
                            ->seconds(false)
                            ->native(false)
                            ->default(function (Competition $record) {
                                if ($record->extended_registration_close_at && $record->extended_registration_close_at->isFuture()) {
                                    return $record->extended_registration_close_at;
                                }
                                $base = ($record->registration_close_at && $record->registration_close_at->isFuture())
                                    ? $record->registration_close_at
                                    : now();

                                return $base->copy()->addDays(7)->setTime(23, 59, 0);
                            })
                            ->helperText(function (Competition $record) {
                                if ($record->registration_close_at) {
                                    return 'Original deadline: '.$record->registration_close_at->format('l, d F Y H:i').' WIB. New deadline must be later than now and the original deadline.';
                                }

                                return 'Must be in the future.';
                            })
                            ->rules([
                                'after:now',
                                function (Forms\Get $get, Competition $record) {
                                    return function (string $attribute, $value, \Closure $fail) use ($record) {
                                        $parsed = Carbon::parse($value);
                                        if ($record->registration_close_at && $parsed->lte($record->registration_close_at)) {
                                            $fail('The extension deadline must be after the original registration deadline ('.$record->registration_close_at->format('d M Y H:i').' WIB).');
                                        }
                                    };
                                },
                            ]),
                        Forms\Components\Toggle::make('auto_adjust_schedule')
                            ->label('Auto-adjust competition timeline if needed')
                            ->helperText('If the new registration deadline exceeds competition start/end dates, automatically shift them forward to maintain a logical sequence.')
                            ->default(true),
                    ])
                    ->action(function (Competition $record, array $data): void {
                        $newClose = Carbon::parse($data['extended_registration_close_at']);
                        $record->extended_registration_close_at = $newClose;

                        if (! empty($data['auto_adjust_schedule'])) {
                            if ($record->competition_start_at && $newClose->gte($record->competition_start_at)) {
                                $record->competition_start_at = $newClose->copy()->addDays(2)->setTime(9, 0, 0);
                            }

                            if ($record->competition_end_at) {
                                $minEnd = $record->competition_start_at
                                    ? $record->competition_start_at->copy()->addDays(3)->setTime(23, 59, 0)
                                    : $newClose->copy()->addDays(5)->setTime(23, 59, 0);

                                if ($newClose->gte($record->competition_end_at) || ($record->competition_start_at && $record->competition_start_at->gte($record->competition_end_at))) {
                                    $record->competition_end_at = $minEnd;
                                }
                            }
                        }

                        $record->save();

                        Notification::make()
                            ->title('Registration Extended')
                            ->body("Registration for {$record->name} is now extended until {$newClose->translatedFormat('l, d F Y H:i')} WIB.")
                            ->success()
                            ->send();
                    }),
                Tables\Actions\Action::make('clear_extension')
                    ->label('Reset Extension')
                    ->icon('heroicon-o-arrow-path')
                    ->color('danger')
                    ->visible(fn (Competition $record) => ! empty($record->extended_registration_close_at) && (! auth()->user()?->hasRole(UserRole::JUDGE->value) || auth()->user()?->hasRole([UserRole::ADMIN->value, UserRole::MODERATOR->value])))
                    ->requiresConfirmation()
                    ->modalHeading('Clear Registration Extension')
                    ->modalDescription(fn (Competition $record) => "Are you sure you want to remove the extended deadline for {$record->name}? The competition will revert back to its original deadline (".($record->registration_close_at?->format('d M Y H:i') ?? 'N/A').').')
                    ->modalSubmitActionLabel('Yes, Reset Extension')
                    ->action(function (Competition $record): void {
                        $record->update(['extended_registration_close_at' => null]);

                        Notification::make()
                            ->title('Extension Cleared')
                            ->body("Registration extension for {$record->name} has been cleared.")
                            ->success()
                            ->send();
                    }),
                Tables\Actions\ViewAction::make()->label('View Details')->icon('heroicon-m-eye')->color('secondary'),
                Tables\Actions\EditAction::make()
                    ->visible(fn () => ! auth()->user()?->hasRole(UserRole::JUDGE->value) || auth()->user()?->hasRole([UserRole::ADMIN->value, UserRole::MODERATOR->value])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ])->visible(fn () => ! auth()->user()?->hasRole(UserRole::JUDGE->value) || auth()->user()?->hasRole([UserRole::ADMIN->value, UserRole::MODERATOR->value])),
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
        if ($user && $user->hasRole(UserRole::JUDGE->value) && ! $user->hasRole([UserRole::ADMIN->value, UserRole::MODERATOR->value])) {
            $query->whereHas('judges', function ($q) use ($user) {
                $q->where('users.id', $user->id);
            });
        }

        return $query;
    }
}
