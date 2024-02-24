<?php

namespace App\Domain\Payment;

use App\Db\Payment\PaymentPersistenceInterface;
use App\DTO\PaymentCreateDTO;
use App\DTO\PaymentListDTO;

class Payment
{
    private ?PaymentPersistenceInterface $paymentPersistence;
    public ?PaymentCreateDTO $createDTO = null;
    public array $paymentsList;
    public PaymentListDTO $paymentList;
    public string $notificationUrl = 'i dont know YET';

    public function __construct(PaymentPersistenceInterface $paymentPersistence = null)
    {
        $this->paymentPersistence = $paymentPersistence;
    }

    public function create(): void
    {
        $this->paymentPersistence->create($this);
    }

    public function listAllPayments(): array
    {
        $this->paymentPersistence->listAllPayments($this);

        $payments = [];
        foreach ($this->paymentsList as $payment) { /* @var $payment PaymentListDto */
            $payments[] = $payment->getAllProperties();
        }

        return $payments;
    }

    public function listPaymentById(string $paymentId): array
    {
        $this->paymentPersistence->listPaymentById($paymentId, $this);

        return $this->paymentList->getAllProperties();
    }

    public function confirmPaymentById(string $paymentId): void
    {
        $this->paymentPersistence->confirmPaymentById($paymentId, $this);
    }

    public function cancelPaymentById(string $paymentId): void
    {
        $this->paymentPersistence->cancelPaymentById($paymentId, $this);
    }

}
