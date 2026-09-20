<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegistrationResource\Pages;
use App\Filament\Resources\RegistrationResource\RelationManagers;
use App\Models\Registration;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Enums\UserRole;

class RegistrationResource extends Resource
{
    protected static ?string $model = Registration::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    public static function getNavigationLabel(): string
    {
        $user = auth()->user();
        if ($user && $user->hasRole(UserRole::JUDGE->value) && !$user->hasRole([UserRole::ADMIN->value, UserRole::MODERATOR->value])) {
            return 'Scoring';
        }

        return 'Verifications & Scoring';
    }

    public static function getNavigationGroup(): ?string
    {
        $user = auth()->user();
        if ($user && $user->hasRole(UserRole::JUDGE->value) && !$user->hasRole([UserRole::ADMIN->value, UserRole::MODERATOR->value])) {
            return 'JUDGING';
        }

        return 'VERIFICATION';
    }

    public static function getNavigationSort(): ?int
    {
        $user = auth()->user();
        if ($user && $user->hasRole(UserRole::JUDGE->value) && !$user->hasRole([UserRole::ADMIN->value, UserRole::MODERATOR->value])) {
            return 2;
        }

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
            return $record->competition->judges()->where('users.id', $user->id)->exists();
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
            return false; // Judge uses Score action
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
                Forms\Components\Select::make('competition_id')
                    ->relationship('competition', 'name')
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Team Leader')
                    ->required(),
                Forms\Components\TextInput::make('team_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('proof_of_payment')
                    ->disk('public')
                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/jpg'])
                    ->directory('payment-proofs')
                    ->downloadable()
                    ->openable()
                    ->visible(fn () => auth()->user()?->hasRole([UserRole::ADMIN->value, UserRole::MODERATOR->value])),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'revision_required' => 'Revision Required',
                    ])
                    ->required()
                    ->default('pending')
                    ->visible(fn () => auth()->user()?->hasRole([UserRole::ADMIN->value, UserRole::MODERATOR->value])),
                Forms\Components\Textarea::make('verification_notes')
                    ->label('Verification Notes (if rejected or needs attention)')
                    ->visible(fn () => auth()->user()?->hasRole([UserRole::ADMIN->value, UserRole::MODERATOR->value])),
                Forms\Components\TextInput::make('grade')
                    ->numeric()
                    ->step('0.01')
                    ->nullable()
                    ->visible(fn () => auth()->user()?->hasRole([UserRole::ADMIN->value, UserRole::JUDGE->value])),
                Forms\Components\FileUpload::make('submission_file_path')
                    ->label('Submitted File')
                    ->disk('public')
                    ->directory('submissions')
                    ->downloadable()
                    ->openable()
                    ->visible(fn () => auth()->user()?->hasRole([UserRole::ADMIN->value, UserRole::JUDGE->value])),
                Forms\Components\TextInput::make('submission_link')
                    ->label('Submitted Link')
                    ->url()
                    ->visible(fn () => auth()->user()?->hasRole([UserRole::ADMIN->value, UserRole::JUDGE->value])),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('team_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Team Leader')
                    ->sortable(),
                Tables\Columns\TextColumn::make('competition.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                        'info' => 'revision_required',
                    ]),
                Tables\Columns\TextColumn::make('grade')
                    ->numeric(2)
                    ->sortable()
                    ->visible(fn () => auth()->user()?->hasRole([UserRole::ADMIN->value, UserRole::JUDGE->value])),
                Tables\Columns\TextColumn::make('submission_link')
                    ->url(fn ($record) => $record->submission_link)
                    ->openUrlInNewTab()
                    ->limit(20)
                    ->visible(fn () => auth()->user()?->hasRole([UserRole::ADMIN->value, UserRole::JUDGE->value])),
                Tables\Columns\TextColumn::make('submission_file_path')
                    ->label('File')
                    ->formatStateUsing(fn ($state) => $state ? 'Download' : '-')
                    ->url(fn ($record) => $record->submission_file_path ? \Illuminate\Support\Facades\Storage::url($record->submission_file_path) : null)
                    ->openUrlInNewTab()
                    ->visible(fn () => auth()->user()?->hasRole([UserRole::ADMIN->value, UserRole::JUDGE->value])),
                Tables\Columns\ImageColumn::make('proof_of_payment')
                    ->label('Payment Proof')
                    ->square()
                    ->visible(fn () => auth()->user()?->hasRole([UserRole::ADMIN->value, UserRole::MODERATOR->value])),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn () => auth()->user()?->hasRole([UserRole::ADMIN->value, UserRole::MODERATOR->value])),
                Action::make('approve')
                    ->label('Approve & Generate Ticket')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Approve Registration')
                    ->modalDescription('Are you sure you want to approve this payment? A ticket will be generated and emailed to the Team Leader.')
                    ->visible(fn (Registration $record): bool => auth()->user()?->hasRole([UserRole::ADMIN->value, UserRole::MODERATOR->value]) && ($record->status === 'pending' || $record->status === 'revision_required'))
                    ->action(function (Registration $record) {
                        $record->update([
                            'status' => 'approved',
                            'verified_by' => auth()->id(),
                            'verified_at' => now(),
                        ]);

                        if (!$record->ticket) {
                            $ticket = Ticket::create([
                                'registration_id' => $record->id,
                                'ticket_code' => 'TKT-' . strtoupper(Str::random(8)),
                            ]);
                        }

                        \Filament\Notifications\Notification::make()
                            ->title('Payment Approved & Ticket Generated')
                            ->success()
                            ->send();
                    }),
                Action::make('reject')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->form([
                        Forms\Components\Textarea::make('verification_notes')
                            ->label('Reason for Rejection')
                            ->required(),
                    ])
                    ->action(function (Registration $record, array $data) {
                        $record->update([
                            'status' => 'rejected',
                            'verification_notes' => $data['verification_notes'],
                            'verified_by' => auth()->id(),
                            'verified_at' => now(),
                        ]);
                    })
                    ->visible(fn (Registration $record): bool => auth()->user()?->hasRole([UserRole::ADMIN->value, UserRole::MODERATOR->value]) && ($record->status === 'pending' || $record->status === 'revision_required')),
                Action::make('require_revision')
                    ->label('Require Revision')
                    ->color('warning')
                    ->icon('heroicon-o-exclamation-circle')
                    ->form([
                        Forms\Components\Textarea::make('verification_notes')
                            ->label('Details of what needs to be revised')
                            ->required(),
                    ])
                    ->action(function (Registration $record, array $data) {
                        $record->update([
                            'status' => 'revision_required',
                            'verification_notes' => $data['verification_notes'],
                            'verified_by' => auth()->id(),
                            'verified_at' => now(),
                        ]);
                    })
                    ->visible(fn (Registration $record): bool => auth()->user()?->hasRole([UserRole::ADMIN->value, UserRole::MODERATOR->value]) && $record->status === 'pending'),
                Action::make('score')
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
                    ->visible(fn (Registration $record): bool => auth()->user()?->hasRole([UserRole::ADMIN->value, UserRole::JUDGE->value]) && $record->status === 'approved' && in_array($record->competition->status, ['ongoing', 'completed'])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('export_csv')
                        ->label('Export CSV')
                        ->icon('heroicon-o-document-arrow-down')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            return response()->streamDownload(function () use ($records) {
                                $handle = fopen('php://output', 'w');
                                fputcsv($handle, ['ID', 'Competition', 'Team Leader', 'Team Name', 'Status', 'Grade', 'Rank', 'Registered At']);
                                foreach ($records as $record) {
                                    fputcsv($handle, [
                                        $record->id,
                                        $record->competition->name ?? '',
                                        $record->user->name ?? '',
                                        $record->team_name,
                                        $record->status,
                                        $record->grade,
                                        $record->rank,
                                        $record->created_at,
                                    ]);
                                }
                                fclose($handle);
                            }, 'registrations_export.csv');
                        })
                        ->visible(fn () => auth()->user()?->hasRole(UserRole::ADMIN->value)),
                    Tables\Actions\DeleteBulkAction::make(),
                ])->visible(fn () => auth()->user()?->hasRole([UserRole::ADMIN->value, UserRole::MODERATOR->value])),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\TeamMembersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRegistrations::route('/'),
            'create' => Pages\CreateRegistration::route('/create'),
            'edit' => Pages\EditRegistration::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        
        $user = auth()->user();
        if ($user && $user->hasRole(UserRole::JUDGE->value) && !$user->hasRole([UserRole::ADMIN->value, UserRole::MODERATOR->value])) {
            $query->whereHas('competition.judges', function ($q) use ($user) {
                $q->where('users.id', $user->id);
            });
        }

        return $query;
    }
}
