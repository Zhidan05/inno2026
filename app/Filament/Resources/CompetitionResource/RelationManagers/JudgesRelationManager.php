<?php

namespace App\Filament\Resources\CompetitionResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class JudgesRelationManager extends RelationManager
{
    protected static string $relationship = 'judges';

    protected static ?string $recordTitleAttribute = 'name';

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        $user = auth()->user();
        if ($user && $user->hasRole(\App\Enums\UserRole::JUDGE->value) && !$user->hasRole([\App\Enums\UserRole::ADMIN->value, \App\Enums\UserRole::MODERATOR->value])) {
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
