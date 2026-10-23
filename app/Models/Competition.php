<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Competition extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'registration_type',
        'max_team_members',
        'registration_fee',
        'registration_open_at',
        'registration_close_at',
        'extended_registration_close_at',
        'competition_start_at',
        'competition_end_at',
        'location',
        'status',
        'submission_type',
    ];

    protected $casts = [
        'registration_open_at' => 'datetime',
        'registration_close_at' => 'datetime',
        'extended_registration_close_at' => 'datetime',
        'competition_start_at' => 'datetime',
        'competition_end_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::saving(function (Competition $competition) {
            $rawStatus = $competition->attributes['status'] ?? null;
            if ($competition->isDirty('status') && $rawStatus === 'registration_open') {
                if (empty($competition->registration_open_at)) {
                    $competition->registration_open_at = now();
                }
            }
        });
    }

    /**
     * Get the effective registration deadline:
     * If extended_registration_close_at is set and greater than registration_close_at,
     * use extended_registration_close_at. Otherwise, use registration_close_at.
     */
    public function getEffectiveRegistrationCloseAtAttribute(): ?Carbon
    {
        if ($this->extended_registration_close_at && (! $this->registration_close_at || $this->extended_registration_close_at->gt($this->registration_close_at))) {
            return $this->extended_registration_close_at;
        }

        return $this->registration_close_at;
    }

    /**
     * Check if registration is currently extended.
     * Returns true if extended_registration_close_at is not null,
     * now() <= extended_registration_close_at, and the competition has not ended.
     */
    public function isExtended(): bool
    {
        if (! $this->extended_registration_close_at) {
            return false;
        }

        if ($this->competition_end_at && now()->gt($this->competition_end_at)) {
            return false;
        }

        return now()->lte($this->extended_registration_close_at);
    }

    /**
     * Label for extended registration status (e.g., 'Extended to Sunday, 25 October 2026').
     */
    public function getExtendedStatusLabelAttribute(): string
    {
        if (! $this->extended_registration_close_at) {
            return '';
        }

        return 'Extended to '.$this->extended_registration_close_at->translatedFormat('l, d F Y');
    }

    /**
     * Calculate the effective status of the competition based on priority rules:
     * 1. Competition Ended: now() > competition_end_at -> 'completed' (or 'results_published')
     * 2. Extended: isExtended() is true -> 'extended' (registration reopened)
     * 3. Registration Closed / Ongoing: now() > effective_registration_close_at
     *    - If now() between competition_start_at and competition_end_at -> 'ongoing'
     *    - If now() < competition_start_at -> 'registration_closed'
     * 4. Ongoing: now() >= competition_start_at
     * 5. Registration Open: within registration window
     * 6. Upcoming: now() < registration_open_at (not yet open)
     */
    public function calculateEffectiveStatus(?string $rawStatus = null): string
    {
        $raw = $rawStatus ?? ($this->attributes['status'] ?? 'draft');

        // Explicit administrative manual statuses to respect
        if (in_array($raw, ['inactive', 'draft', 'results_published'])) {
            return $raw;
        }

        $now = now();

        // Priority 1 (Top Priority): Competition Ended
        if ($this->competition_end_at && $now->gt($this->competition_end_at)) {
            return 'completed';
        }

        // Priority 2: Extended Registration Active
        if ($this->isExtended()) {
            return 'extended';
        }

        // Priority 3: Registration Closed / Competition Ongoing (uses effective close deadline)
        $effectiveClose = $this->effective_registration_close_at;
        if ($effectiveClose && $now->gt($effectiveClose)) {
            if ($this->competition_start_at && $now->gte($this->competition_start_at)) {
                return 'ongoing';
            }

            return 'registration_closed';
        }

        // Competition has started even if no close date was explicitly provided
        if ($this->competition_start_at && $now->gte($this->competition_start_at)) {
            return 'ongoing';
        }

        // Priority 4: Registration Open (Admin early override OR registration date reached)
        $notClosed = ! $effectiveClose || $now->lte($effectiveClose);
        $notEnded = ! $this->competition_end_at || $now->lte($this->competition_end_at);

        if ($notClosed && $notEnded) {
            $dateReached = $this->registration_open_at && $now->gte($this->registration_open_at);
            $adminOverride = ($raw === 'registration_open');

            if ($dateReached || $adminOverride) {
                return 'registration_open';
            }
        }

        // Priority 5: Upcoming / Coming Soon
        if ($this->registration_open_at && $now->lt($this->registration_open_at)) {
            return 'upcoming';
        }

        return $raw ?: 'draft';
    }

    /**
     * Accessor for status attribute: returns the effective prioritized status.
     */
    public function getStatusAttribute(?string $value): string
    {
        return $this->calculateEffectiveStatus($value);
    }

    /**
     * Check if registration is strictly open.
     */
    public function isRegistrationOpen(): bool
    {
        return in_array($this->status, ['registration_open', 'extended'])
            && (! $this->effective_registration_close_at || now()->lte($this->effective_registration_close_at))
            && (! $this->competition_end_at || now()->lte($this->competition_end_at));
    }

    /**
     * Check if the competition has ended.
     */
    public function isEnded(): bool
    {
        return in_array($this->status, ['completed', 'results_published'])
            || ($this->competition_end_at && now()->gt($this->competition_end_at));
    }

    /**
     * Check if the competition is currently ongoing.
     */
    public function isOngoing(): bool
    {
        return $this->status === 'ongoing';
    }

    /**
     * Synchronize effective statuses to the database.
     */
    public static function syncAllStatuses(): int
    {
        $updatedCount = 0;
        $competitions = static::whereNotIn('status', ['draft', 'inactive'])->get();

        foreach ($competitions as $competition) {
            $raw = $competition->getRawOriginal('status');
            $effective = $competition->calculateEffectiveStatus($raw);

            if ($effective !== $raw && ! in_array($raw, ['draft', 'inactive'])) {
                static::where('id', $competition->id)->update(['status' => $effective]);
                $updatedCount++;
            }
        }

        return $updatedCount;
    }

    /**
     * Determine if this competition is free (no registration fee).
     */
    public function isFree(): bool
    {
        return (float) $this->registration_fee <= 0;
    }

    /**
     * Determine if this competition requires payment proof.
     */
    public function requiresPayment(): bool
    {
        return ! $this->isFree();
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function judges(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'competition_judge');
    }
}
