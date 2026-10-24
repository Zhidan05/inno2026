<?php

namespace App\Models;

use App\Enums\PaymentMethodType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class PaymentMethod extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'type',
        'instructions',
        'is_active',
        'sort_order',
        'qris_image',
        'bank_name',
        'account_number',
        'account_holder_name',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => PaymentMethodType::class,
            'is_active' => 'boolean',
            'sort_order' => 'integer',
            'account_number' => 'string',
        ];
    }

    protected static function booted(): void
    {
        static::deleted(function (PaymentMethod $paymentMethod) {
            if ($paymentMethod->qris_image && Storage::disk('public')->exists($paymentMethod->qris_image)) {
                Storage::disk('public')->delete($paymentMethod->qris_image);
            }
        });
    }

    /**
     * Relationship with registrations.
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Scope active payment methods ordered by display sort order.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc');
    }

    /**
     * Check if payment method is QRIS.
     */
    public function isQris(): bool
    {
        return $this->type === PaymentMethodType::QRIS;
    }

    /**
     * Check if payment method is Bank Transfer.
     */
    public function isBankTransfer(): bool
    {
        return $this->type === PaymentMethodType::BANK_TRANSFER;
    }

    /**
     * Get public URL of the QRIS image.
     */
    public function getQrisImageUrlAttribute(): ?string
    {
        if (! $this->qris_image) {
            return null;
        }

        return Storage::disk('public')->url($this->qris_image);
    }
}
