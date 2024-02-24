<?php

namespace App\DTO;

use App\Domain\Payment\ValueObject\PaymentStatusVO;
use App\ValueObject\DateVO;
use App\ValueObject\IdVO;

class PaymentStatusUpdateDTO
{
    public function __construct(
        public readonly IdVO $id,
        public readonly PaymentStatusVO $status,
        public readonly DateVO $updatedDate
    ) {
    }
}
