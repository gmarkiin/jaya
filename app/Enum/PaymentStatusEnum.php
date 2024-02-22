<?php

namespace App\Enum;

enum PaymentStatusEnum: string
{
    case PENDING = 'pending';
    case PAID = 'paid';
    case CANCELED = 'canceled';

    public static function availableStatus(): array
    {
        return [
            self::PENDING->value,
            self::PAID->value,
            self::CANCELED->value
        ];
    }
}
