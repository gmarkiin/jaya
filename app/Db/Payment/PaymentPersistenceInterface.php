<?php

namespace App\Db\Payment;

use App\Domain\Payment\Payment;

interface PaymentPersistenceInterface
{
    public function create(Payment $payment): void;

    public function listAllPayments(Payment $payment): void;
}
