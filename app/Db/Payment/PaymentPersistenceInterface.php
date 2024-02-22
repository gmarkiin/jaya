<?php

namespace App\Db\Payment;

use App\Domain\Payment;

interface PaymentPersistenceInterface
{
    public function create(Payment $payment);
}
