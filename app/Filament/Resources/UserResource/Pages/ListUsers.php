<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('export_csv')
                ->label('Export CSV')
                ->icon('heroicon-o-document-arrow-down')
                ->action(function () {
                    return response()->streamDownload(function () {
                        $handle = fopen('php://output', 'w');
                        fputcsv($handle, ['ID', 'Name', 'Email', 'Phone', 'Institution', 'Joined At']);
                        foreach (\App\Models\User::all() as $record) {
                            fputcsv($handle, [
                                $record->id,
                                $record->name,
                                $record->email,
                                $record->phone,
                                $record->institution,
                                $record->created_at,
                            ]);
                        }
                        fclose($handle);
                    }, 'users_export.csv');
                })
                ->visible(fn () => auth()->user()?->hasRole('super_admin')),
            Actions\CreateAction::make(),
        ];
    }
}
