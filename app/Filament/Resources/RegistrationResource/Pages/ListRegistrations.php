<?php

namespace App\Filament\Resources\RegistrationResource\Pages;

use App\Filament\Resources\RegistrationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRegistrations extends ListRecords
{
    protected static string $resource = RegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('export_csv')
                ->label('Export CSV')
                ->icon('heroicon-o-document-arrow-down')
                ->action(function () {
                    return response()->streamDownload(function () {
                        $handle = fopen('php://output', 'w');
                        fputcsv($handle, ['ID', 'Competition', 'Team Leader', 'Team Name', 'Status', 'Grade', 'Rank', 'Registered At']);
                        foreach (\App\Models\Registration::with(['competition', 'user'])->get() as $record) {
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
                ->visible(fn () => auth()->user()?->hasRole(\App\Enums\UserRole::ADMIN->value)),
            Actions\CreateAction::make(),
        ];
    }
}
