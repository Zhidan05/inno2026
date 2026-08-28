<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'competition_id',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function competition(): BelongsTo
    {
        return $this->belongsTo(Competition::class);
    }
}
