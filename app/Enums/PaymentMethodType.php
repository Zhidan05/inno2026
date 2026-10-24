<?php

namespace App\Enums;

enum PaymentMethodType: string
{
    case QRIS = 'qris';
    case BANK_TRANSFER = 'bank_transfer';

    public function label(): string
    {
        return match ($this) {
            self::QRIS => 'QRIS',
            self::BANK_TRANSFER => 'Bank Transfer',
        };
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return [
            self::QRIS->value => self::QRIS->label(),
            self::BANK_TRANSFER->value => self::BANK_TRANSFER->label(),
        ];
    }
}
