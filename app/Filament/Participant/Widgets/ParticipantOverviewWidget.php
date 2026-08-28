<?php

namespace App\Filament\Participant\Widgets;

use Filament\Widgets\Widget;
use App\Models\Registration;

class ParticipantOverviewWidget extends Widget
{
    protected static string $view = 'filament.participant.widgets.participant-overview-widget';

    protected int | string | array $columnSpan = 'full';

    public ?Registration $registration = null;
    public ?int $rank = null;

    public function mount(): void
    {
        $this->registration = Registration::with('competition')
            ->where('user_id', auth()->id())
            ->first();

        if ($this->registration && $this->registration->grade !== null) {
            $this->rank = Registration::where('competition_id', $this->registration->competition_id)
                ->where('grade', '>', $this->registration->grade)
                ->count() + 1;
        }
    }
}
