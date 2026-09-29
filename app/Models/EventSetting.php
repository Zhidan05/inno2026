<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventSetting extends Model
{
    /** @var list<string> */
    protected $fillable = [
        'countdown_target_at',
        'countdown_enabled',
        'countdown_label',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'countdown_target_at' => 'datetime',
            'countdown_enabled' => 'boolean',
        ];
    }

    /**
     * Retrieve the singleton event settings record.
     *
     * Always returns a single row — creates one if none exists.
     */
    public static function current(): self
    {
        return static::firstOrCreate([], [
            'countdown_enabled' => true,
            'countdown_label' => 'EVENT COUNTDOWN',
        ]);
    }
}
