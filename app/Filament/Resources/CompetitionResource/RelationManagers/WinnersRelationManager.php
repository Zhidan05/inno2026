<?php

namespace App\Filament\Resources\CompetitionResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class WinnersRelationManager extends RelationManager
{
    protected static string $relationship = 'registrations';

    protected static ?string $recordTitleAttribute = 'team_name';
    
    protected static ?string $title = 'Winners / Results';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('team_name')
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'approved')->whereNotNull('grade')->orderByDesc('grade'))
            ->columns([
                Tables\Columns\TextColumn::make('rank')
                    ->label('Rank')
                    ->getStateUsing(fn ($record, $rowLoop) => $rowLoop->iteration),
                Tables\Columns\TextColumn::make('team_name')
                    ->label('Participant / Team')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Leader')
                    ->searchable(),
                Tables\Columns\TextColumn::make('grade')
                    ->label('Score')
                    ->numeric(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ])
            ->paginated(false); // Typically you'd want to see the top results without pagination on a detail page.
    }
}
