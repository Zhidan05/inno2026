<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'competition_id',
        'user_id',
        'registration_mode',
        'team_name',
        'proof_of_payment',
        'status',
        'grade',
        'verification_notes',
        'verified_by',
        'verified_at',
        'submission_file_path',
        'submission_link',
        'submitted_at',
        'scored_by',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'submitted_at' => 'datetime',
    ];

    public function competition(): BelongsTo
    {
        return $this->belongsTo(Competition::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function judge(): BelongsTo
    {
        return $this->belongsTo(User::class, 'scored_by');
    }

    public function members(): HasMany
    {
        return $this->hasMany(TeamMember::class);
    }

    public function ticket(): HasOne
    {
        return $this->hasOne(Ticket::class);
    }

    /**
     * Calculate rank among verified participants in the same competition.
     */
    public function getRankAttribute()
    {
        if ($this->status !== 'approved' || is_null($this->grade)) {
            return null;
        }

        // Count how many verified participants have a strictly higher score
        $higherScoresCount = Registration::where('competition_id', $this->competition_id)
            ->where('status', 'approved')
            ->whereNotNull('grade')
            ->where('grade', '>', $this->grade)
            ->count();

        return $higherScoresCount + 1;
    }
}
