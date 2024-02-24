<?php

namespace App\Db\Payment;

use App\Domain\Payment\Payment;

interface PaymentPersistenceInterface
{
    public function create(Payment $payment): void;

    public function listAllPayments(Payment $payment): void;

    public function listPaymentById(string $paymentId, Payment $payment): void;

    public function confirmPaymentById(string $paymentId, Payment $payment): void;

    public function cancelPaymentById(string $paymentId, Payment $payment): void;
}
