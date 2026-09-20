<?php

namespace App\Filament\Widgets;

use App\Models\Registration;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentRegistrations extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 2;

    public static function canView(): bool
    {
        $user = auth()->user();
        return $user && $user->hasRole([\App\Enums\UserRole::ADMIN->value, \App\Enums\UserRole::MODERATOR->value]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Registration::query()->latest()->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Participant')
                    ->searchable(),
                Tables\Columns\TextColumn::make('competition.name')
                    ->label('Competition'),
                Tables\Columns\TextColumn::make('team_name')
                    ->label('Team Name')
                    ->formatStateUsing(fn (?string $state, Registration $record) => $record->registration_mode === 'solo' ? 'Individual' : ($state ?? '-')),
                Tables\Columns\TextColumn::make('status')
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
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted At')
                    ->dateTime('d M Y, H:i'),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->icon('heroicon-m-eye')
                    ->url(fn (Registration $record): string => \App\Filament\Resources\ParticipantResource::getUrl('view', ['record' => $record])),
            ])
            ->paginated(false);
    }
}
