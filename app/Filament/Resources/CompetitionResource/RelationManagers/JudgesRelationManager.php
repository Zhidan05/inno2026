<?php

namespace App\Filament\Resources\CompetitionResource\RelationManagers;

use App\Enums\UserRole;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class JudgesRelationManager extends RelationManager
{
    protected static string $relationship = 'judges';

    protected static ?string $recordTitleAttribute = 'name';

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        $user = auth()->user();
        if ($user && $user->hasRole(UserRole::JUDGE->value) && ! $user->hasRole([UserRole::ADMIN->value, UserRole::MODERATOR->value])) {
            return false;
        }

        return true;
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // We're just viewing here to keep historical records safe.
                // Assignment is done on the edit page.
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ]);
    }
}
