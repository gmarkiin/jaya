<?php

namespace App\DTO;

use App\Domain\Payment\ValueObject\DateVO;
use App\Domain\Payment\ValueObject\IdVO;
use App\Domain\Payment\ValueObject\PaymentStatusVO;

class PaymentStatusUpdateDTO
{
    public function __construct(
        public readonly IdVO $id,
        public readonly PaymentStatusVO $status,
        public readonly DateVO $updatedDate
    ) {
    }
}
