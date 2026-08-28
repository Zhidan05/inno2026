<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'ticket_code',
    ];

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }
}
