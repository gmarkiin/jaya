<?php

namespace App\DTO;

use App\Enum\PaymentStatusEnum;

class PaymentDTO
{
    public readonly string $id;
    public readonly PaymentStatusEnum $status;
    public readonly string $createdAt;
    public readonly string $updatedAt;
}
