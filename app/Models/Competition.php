<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'competition_start_at',
        'competition_end_at',
        'location',
        'status',
        'submission_type',
    ];

    protected $casts = [
        'registration_open_at' => 'datetime',
        'registration_close_at' => 'datetime',
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
     * Calculate the effective status of the competition based on priority rules:
     * 1. Competition Ended: now() > competition_end_at -> 'completed' (or 'results_published')
     * 2. Registration Closed / Ongoing: now() > registration_close_at
     *    - If now() between competition_start_at and competition_end_at -> 'ongoing'
     *    - If now() < competition_start_at -> 'registration_closed'
     * 3. Registration Open: now() <= registration_close_at AND now() <= competition_end_at
     *    AND (now() >= registration_open_at OR Admin set 'registration_open')
     * 4. Upcoming: now() < registration_open_at (not yet open)
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

        // Priority 2: Registration Closed / Competition Ongoing
        if ($this->registration_close_at && $now->gt($this->registration_close_at)) {
            if ($this->competition_start_at && $now->gte($this->competition_start_at)) {
                return 'ongoing';
            }

            return 'registration_closed';
        }

        // Competition has started even if registration_close_at was not explicitly provided
        if ($this->competition_start_at && $now->gte($this->competition_start_at)) {
            return 'ongoing';
        }

        // Priority 3: Registration Open (Admin early override OR registration date reached)
        $notClosed = ! $this->registration_close_at || $now->lte($this->registration_close_at);
        $notEnded = ! $this->competition_end_at || $now->lte($this->competition_end_at);

        if ($notClosed && $notEnded) {
            $dateReached = $this->registration_open_at && $now->gte($this->registration_open_at);
            $adminOverride = ($raw === 'registration_open');

            if ($dateReached || $adminOverride) {
                return 'registration_open';
            }
        }

        // Priority 4: Upcoming / Coming Soon
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
        return $this->status === 'registration_open'
            && (! $this->registration_close_at || now()->lte($this->registration_close_at))
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
