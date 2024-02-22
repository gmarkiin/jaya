<?php

namespace App\Domain\Payment;

use App\Db\Payment\PaymentPersistenceInterface;
use App\DTO\PaymentCreateDTO;

class Payment
{
    private ?PaymentPersistenceInterface $paymentPersistence;
    public ?PaymentCreateDTO $createDTO = null;
    public string $notificationUrl = 'i dont know YET';

    public function __construct(PaymentPersistenceInterface $paymentPersistence = null)
    {
        $this->paymentPersistence = $paymentPersistence;
    }

    public function create(): void
    {
        $this->paymentPersistence->create($this);
    }

}
