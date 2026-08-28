<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MediaPartnerResource\Pages;
use App\Models\MediaPartner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MediaPartnerResource extends Resource
{
    protected static ?string $model = MediaPartner::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationGroup = 'SYSTEM';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('logo')
                    ->image()
                    ->required()
                    ->directory('media_partners')
                    ->saveUploadedFileUsing(function (\Livewire\Features\SupportFileUploads\TemporaryUploadedFile $file): string {
                        $img = @imagecreatefromstring($file->get());
                        if (!$img) {
                            return $file->store('media_partners', 'public');
                        }
                        imagepalettetotruecolor($img);
                        imagealphablending($img, true);
                        imagesavealpha($img, true);
                        
                        $filename = 'media_partners/' . \Illuminate\Support\Str::uuid() . '.webp';
                        ob_start();
                        imagewebp($img, null, 80);
                        $imageData = ob_get_clean();
                        imagedestroy($img);
                        
                        \Illuminate\Support\Facades\Storage::disk('public')->put($filename, $imageData);
                        return $filename;
                    })
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('link')
                    ->url()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                    ->square(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('link')
                    ->url(fn ($record) => $record->link, true)
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageMediaPartners::route('/'),
        ];
    }
}
