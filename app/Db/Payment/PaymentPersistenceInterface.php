<?php

namespace App\Db\Payment;

use App\Domain\Payment\Payment;
use App\ValueObject\IdVO;

interface PaymentPersistenceInterface
{
    public function create(Payment $payment): void;

    public function listAllPayments(Payment $payment): void;

    public function listPaymentById(IdVO $paymentId, Payment $payment): void;

    public function confirmPaymentById(Payment $payment): void;

    public function cancelPaymentById(Payment $payment): void;
}
