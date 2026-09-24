<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use Illuminate\Validation\Rule;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'MANAGEMENT';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nim')
                    ->label('NIM')
                    ->maxLength(30)
                    ->required(fn (Forms\Get $get): bool => $get('role') === \App\Enums\UserRole::PARTICIPANT->value)
                    ->rules(fn (?User $record) => [
                        Rule::unique('users', 'nim')->ignore($record?->id),
                    ]),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('role')
                    ->label('Role')
                    ->options([
                        \App\Enums\UserRole::ADMIN->value => \App\Enums\UserRole::ADMIN->label(),
                        \App\Enums\UserRole::MODERATOR->value => \App\Enums\UserRole::MODERATOR->label(),
                        \App\Enums\UserRole::JUDGE->value => \App\Enums\UserRole::JUDGE->label(),
                        \App\Enums\UserRole::PARTICIPANT->value => \App\Enums\UserRole::PARTICIPANT->label(),
                    ])
                    ->afterStateHydrated(function (Forms\Components\Select $component, ?User $record) {
                        if ($record && $record->exists) {
                            $component->state($record->roles()->first()?->name);
                        }
                    })
                    ->saveRelationshipsUsing(function (User $record, $state) {
                        $currentUser = auth()->user();
                        if ($currentUser && $currentUser->hasRole(\App\Enums\UserRole::ADMIN->value)) {
                            if ($record->hasRole(\App\Enums\UserRole::ADMIN->value) && $state !== \App\Enums\UserRole::ADMIN->value) {
                                if (\App\Models\User::role(\App\Enums\UserRole::ADMIN->value)->count() <= 1) {
                                    throw \Illuminate\Validation\ValidationException::withMessages(['role' => 'At least one Admin account must remain active.']);
                                }
                            }
                            $record->syncRoles([$state]);
                        } else if ($currentUser && $currentUser->hasRole(\App\Enums\UserRole::MODERATOR->value)) {
                            $record->syncRoles([\App\Enums\UserRole::PARTICIPANT->value]);
                        }
                    })
                    ->dehydrated(false)
                    ->disabled(fn () => !auth()->user()?->hasRole(\App\Enums\UserRole::ADMIN->value))
                    ->default(fn () => auth()->user()?->hasRole(\App\Enums\UserRole::ADMIN->value) ? null : \App\Enums\UserRole::PARTICIPANT->value)
                    ->required(),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create')
                    ->label('Password'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nim')
                    ->label('NIM')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        \App\Enums\UserRole::ADMIN->value => \App\Enums\UserRole::ADMIN->label(),
                        \App\Enums\UserRole::MODERATOR->value => \App\Enums\UserRole::MODERATOR->label(),
                        \App\Enums\UserRole::JUDGE->value => \App\Enums\UserRole::JUDGE->label(),
                        \App\Enums\UserRole::PARTICIPANT->value => \App\Enums\UserRole::PARTICIPANT->label(),
                        default => ucfirst($state),
                    })
                    ->colors([
                        'warning' => \App\Enums\UserRole::ADMIN->value,
                        'info' => \App\Enums\UserRole::MODERATOR->value,
                        'primary' => \App\Enums\UserRole::JUDGE->value,
                        'gray' => \App\Enums\UserRole::PARTICIPANT->value,
                    ]),
                Tables\Columns\TextColumn::make('registrations_count')
                    ->counts('registrations')
                    ->label('Competitions')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('roles')
                    ->relationship('roles', 'name')
                    ->label('Role'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('export_csv')
                        ->label('Export CSV')
                        ->icon('heroicon-o-document-arrow-down')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            return response()->streamDownload(function () use ($records) {
                                $handle = fopen('php://output', 'w');
                                fputcsv($handle, ['ID', 'Name', 'NIM', 'Email', 'Phone', 'Institution', 'Joined At']);
                                foreach ($records as $record) {
                                    fputcsv($handle, [
                                        $record->id,
                                        $record->name,
                                        $record->nim,
                                        $record->email,
                                        $record->phone,
                                        $record->institution,
                                        $record->created_at,
                                    ]);
                                }
                                fclose($handle);
                            }, 'users_export.csv');
                        })
                        ->visible(fn () => auth()->user()?->hasRole(\App\Enums\UserRole::ADMIN->value)),
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => auth()->user()?->hasRole(\App\Enums\UserRole::ADMIN->value)),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('User Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('name'),
                        Infolists\Components\TextEntry::make('nim')
                            ->label('NIM')
                            ->formatStateUsing(fn (?string $state) => $state ?? '-'),
                        Infolists\Components\TextEntry::make('email'),
                        Infolists\Components\TextEntry::make('roles.name')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                \App\Enums\UserRole::ADMIN->value => \App\Enums\UserRole::ADMIN->label(),
                                \App\Enums\UserRole::MODERATOR->value => \App\Enums\UserRole::MODERATOR->label(),
                                \App\Enums\UserRole::JUDGE->value => \App\Enums\UserRole::JUDGE->label(),
                                \App\Enums\UserRole::PARTICIPANT->value => \App\Enums\UserRole::PARTICIPANT->label(),
                                default => ucfirst($state),
                            })
                            ->colors([
                                'warning' => \App\Enums\UserRole::ADMIN->value,
                                'info' => \App\Enums\UserRole::MODERATOR->value,
                                'primary' => \App\Enums\UserRole::JUDGE->value,
                                'gray' => \App\Enums\UserRole::PARTICIPANT->value,
                            ]),
                        Infolists\Components\TextEntry::make('created_at')
                            ->dateTime('d M Y, H:i'),
                        Infolists\Components\TextEntry::make('updated_at')
                            ->dateTime('d M Y, H:i'),
                    ])->columns(2),

                Infolists\Components\Section::make('Competition Activity')
                    ->schema([
                        Infolists\Components\TextEntry::make('registrations_count')
                            ->state(fn ($record) => $record->registrations()->count())
                            ->label('Total Registrations'),
                        Infolists\Components\TextEntry::make('verified_count')
                            ->state(fn ($record) => $record->registrations()->where('status', 'approved')->count())
                            ->label('Verified Registrations'),
                        Infolists\Components\TextEntry::make('pending_count')
                            ->state(fn ($record) => $record->registrations()->whereIn('status', ['pending', 'revision_required'])->count())
                            ->label('Pending/Revision Registrations'),
                        Infolists\Components\TextEntry::make('rejected_count')
                            ->state(fn ($record) => $record->registrations()->where('status', 'rejected')->count())
                            ->label('Rejected Registrations'),
                    ])->columns(4)
                    ->visible(fn ($record) => $record->hasRole('participant')),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\RegistrationsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole([\App\Enums\UserRole::ADMIN->value, \App\Enums\UserRole::MODERATOR->value]) ?? false;
    }
}
