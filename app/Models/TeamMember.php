<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'name',
        'nim',
    ];

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }
}
