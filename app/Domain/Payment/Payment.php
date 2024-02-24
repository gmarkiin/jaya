<?php

namespace App\Domain\Payment;

use App\Db\Payment\PaymentPersistenceInterface;
use App\DTO\PaymentCreateDTO;
use App\DTO\PaymentListDTO;
use App\DTO\PaymentStatusUpdateDTO;
use App\ValueObject\IdVO;

class Payment
{
    private ?PaymentPersistenceInterface $paymentPersistence;
    public ?PaymentCreateDTO $createDTO = null;
    public PaymentListDTO $paymentList;
    public PaymentStatusUpdateDTO $paymentStatusUpdateDTO;
    public array $paymentsList;

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

    public function listPaymentById(IdVO $paymentId): array
    {
        $this->paymentPersistence->listPaymentById($paymentId, $this);

        return $this->paymentList->getAllProperties();
    }

    public function confirmPaymentById(): void
    {
        $this->paymentPersistence->confirmPaymentById($this);
    }

    public function cancelPaymentById(): void
    {
        $this->paymentPersistence->cancelPaymentById($this);
    }
}
