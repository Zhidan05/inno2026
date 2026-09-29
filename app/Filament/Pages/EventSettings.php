<?php

namespace App\Filament\Pages;

use App\Enums\UserRole;
use App\Models\EventSetting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class EventSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $navigationGroup = 'SYSTEM';

    protected static ?string $navigationLabel = 'Event Settings';

    protected static ?string $title = 'Event Settings';

    protected static ?int $navigationSort = 100;

    protected static string $view = 'filament.pages.event-settings';

    public ?array $data = [];

    public static function canAccess(): bool
    {
        $user = auth()->user();

        return $user && $user->hasRole([
            UserRole::ADMIN->value,
            UserRole::MODERATOR->value,
        ]);
    }

    public function mount(): void
    {
        $setting = EventSetting::current();

        $this->form->fill([
            'countdown_enabled' => $setting->countdown_enabled,
            'countdown_target_at' => $setting->countdown_target_at,
            'countdown_label' => $setting->countdown_label,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Event Countdown')
                    ->description('Configure the public homepage countdown timer.')
                    ->icon('heroicon-o-clock')
                    ->schema([
                        Forms\Components\Toggle::make('countdown_enabled')
                            ->label('Countdown Status')
                            ->helperText('When disabled, the countdown section is hidden from the homepage.')
                            ->default(true),

                        Forms\Components\DateTimePicker::make('countdown_target_at')
                            ->label('Countdown Target')
                            ->helperText('The date and time the countdown counts down to. Uses the application timezone ('.config('app.timezone').').')
                            ->seconds(false)
                            ->native(false)
                            ->nullable(),

                        Forms\Components\TextInput::make('countdown_label')
                            ->label('Countdown Label')
                            ->helperText('Displayed above the countdown numbers (e.g. "EVENT COUNTDOWN", "REGISTRATION CLOSES IN").')
                            ->placeholder('EVENT COUNTDOWN')
                            ->maxLength(100),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $setting = EventSetting::current();
        $setting->update([
            'countdown_enabled' => $data['countdown_enabled'] ?? true,
            'countdown_target_at' => $data['countdown_target_at'] ?? null,
            'countdown_label' => $data['countdown_label'] ?? 'EVENT COUNTDOWN',
        ]);

        Notification::make()
            ->title('Event settings saved')
            ->success()
            ->send();
    }
}
