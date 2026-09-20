<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
            if ($competition->isDirty('status') && $competition->status === 'registration_open') {
                if (empty($competition->registration_open_at)) {
                    $competition->registration_open_at = now();
                }
            }
        });
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function judges(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'competition_judge');
    }
}
