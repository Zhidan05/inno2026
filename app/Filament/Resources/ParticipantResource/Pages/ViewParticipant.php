<?php

namespace App\Filament\Resources\ParticipantResource\Pages;

use App\Filament\Resources\ParticipantResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewParticipant extends ViewRecord
{
    protected static string $resource = ParticipantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->visible(fn () => auth()->user()?->hasRole(\App\Enums\UserRole::ADMIN->value)),
            Actions\Action::make('view_payment')
                ->label('View Payment Proof')
                ->icon('heroicon-o-document-text')
                ->url(fn ($record) => $record->proof_of_payment ? asset('storage/' . $record->proof_of_payment) : null)
                ->openUrlInNewTab()
                ->visible(fn ($record) => $record->proof_of_payment !== null),
            Actions\Action::make('approve')
                ->label('Approve & Generate Ticket')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn ($record) => in_array($record->status, ['pending', 'revision_required']) && auth()->user()?->hasRole([\App\Enums\UserRole::ADMIN->value, \App\Enums\UserRole::MODERATOR->value]))
                ->action(function ($record) {
                    $record->update([
                        'status' => 'approved',
                        'verified_by' => auth()->id(),
                        'verified_at' => now(),
                    ]);
                    if (!$record->ticket) {
                        \App\Models\Ticket::create([
                            'registration_id' => $record->id,
                            'ticket_code' => 'TKT-' . strtoupper(\Illuminate\Support\Str::random(8)),
                        ]);
                    }
                    \Filament\Notifications\Notification::make()->title('Approved')->success()->send();
                }),
            Actions\Action::make('require_revision')
                ->label('Require Revision')
                ->icon('heroicon-o-exclamation-circle')
                ->color('warning')
                ->form([
                    \Filament\Forms\Components\Textarea::make('verification_notes')->required()->label('Revision Notes'),
                ])
                ->visible(fn ($record) => $record->status === 'pending' && auth()->user()?->hasRole([\App\Enums\UserRole::ADMIN->value, \App\Enums\UserRole::MODERATOR->value]))
                ->action(function ($record, array $data) {
                    $record->update([
                        'status' => 'revision_required',
                        'verification_notes' => $data['verification_notes'],
                        'verified_by' => auth()->id(),
                        'verified_at' => now(),
                    ]);
                    \Filament\Notifications\Notification::make()->title('Revision Required')->success()->send();
                }),
            Actions\Action::make('reject')
                ->label('Reject Registration')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->form([
                    \Filament\Forms\Components\Textarea::make('verification_notes')->required()->label('Rejection Reason'),
                ])
                ->visible(fn ($record) => in_array($record->status, ['pending', 'revision_required']) && auth()->user()?->hasRole([\App\Enums\UserRole::ADMIN->value, \App\Enums\UserRole::MODERATOR->value]))
                ->action(function ($record, array $data) {
                    $record->update([
                        'status' => 'rejected',
                        'verification_notes' => $data['verification_notes'],
                        'verified_by' => auth()->id(),
                        'verified_at' => now(),
                    ]);
                    \Filament\Notifications\Notification::make()->title('Rejected')->success()->send();
                }),
        ];
    }
}
