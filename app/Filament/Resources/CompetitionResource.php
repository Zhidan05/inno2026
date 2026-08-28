<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompetitionResource\Pages;
use App\Models\Competition;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CompetitionResource extends Resource
{
    protected static ?string $model = Competition::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';
    protected static ?string $navigationGroup = 'MANAGEMENT';

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
                    ])
                    ->required()
                    ->default('draft'),
                Forms\Components\DateTimePicker::make('registration_open_at'),
                Forms\Components\DateTimePicker::make('registration_close_at'),
                Forms\Components\DateTimePicker::make('competition_start_at'),
                Forms\Components\DateTimePicker::make('competition_end_at'),
                Forms\Components\Select::make('judges')
                    ->multiple()
                    ->relationship('judges', 'name')
                    ->preload()
                    ->columnSpanFull()
                    ->visible(fn () => auth()->user()?->hasRole('super_admin')),
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
                        'success' => 'registration_open',
                        'danger' => 'registration_closed',
                        'warning' => 'upcoming',
                        'primary' => 'ongoing',
                        'gray' => 'completed',
                        'success' => 'results_published',
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
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListCompetitions::route('/'),
            'create' => Pages\CreateCompetition::route('/create'),
            'edit' => Pages\EditCompetition::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if ($user && $user->hasRole('judge')) {
            $query->whereHas('judges', function ($q) use ($user) {
                $q->where('users.id', $user->id);
            });
        }

        return $query;
    }
}
