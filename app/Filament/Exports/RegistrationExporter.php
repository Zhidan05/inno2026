<?php

namespace App\Filament\Exports;

use App\Models\Participant;
use App\Models\Registration;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class RegistrationExporter extends Exporter
{
    protected static ?string $model = Registration::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('competition.name')
                ->label('Competition'),
            ExportColumn::make('user.name')
                ->label('Team Leader'),
            ExportColumn::make('team_name')
                ->label('Team Name'),
            ExportColumn::make('status')
                ->label('Status'),
            ExportColumn::make('grade')
                ->label('Grade'),
            ExportColumn::make('rank')
                ->label('Rank'),
            ExportColumn::make('created_at')
                ->label('Registered At'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your registrations export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
