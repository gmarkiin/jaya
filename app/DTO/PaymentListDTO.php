<?php

namespace App\DTO;

use App\Domain\Payment\ValueObject\DateVO;
use App\Domain\Payment\ValueObject\IdVO;
use App\Domain\Payment\ValueObject\InstallmentVO;
use App\Domain\Payment\ValueObject\PaymentStatusVO;
use App\Domain\Payment\ValueObject\StringVO;
use App\Domain\Payment\ValueObject\TransactionAmountVO;
use App\Domain\Payment\ValueObject\UrlVO;
use App\Exceptions\InvalidPropertyValueException;
use stdClass;

class PaymentListDTO
{
    public readonly TransactionAmountVO $transactionAmount;
    public readonly InstallmentVO $installments;
    public readonly StringVO $token;
    public readonly StringVO $paymentMethodId;
    public readonly StringVO $payerEmail;
    public readonly StringVO $payerIdentificationType;
    public readonly StringVO $payerIdentificationNumber;
    public readonly StringVO $payerEntityType;
    public readonly StringVO $payerType;
    public readonly IdVO $id;
    public readonly PaymentStatusVO $status;
    public readonly DateVO $createdAt;
    public readonly ?DateVO $updatedAt;
    public readonly UrlVO $notificationUrl;

    /**
     * @throws InvalidPropertyValueException
     */
    public function __construct(stdClass $data)
    {
        $this->id = new IdVO($data->id);
        $this->status = new PaymentStatusVO($data->status);
        $this->transactionAmount = new TransactionAmountVO($data->transaction_amount);
        $this->installments = new InstallmentVO($data->installments);
        $this->token = new StringVO($data->token);
        $this->paymentMethodId = new StringVO($data->payment_method_id);
        $this->payerEntityType = new StringVO($data->payer_entity_type);
        $this->payerType = new StringVO($data->payer_type);
        $this->payerEmail = new StringVO($data->payer_email);
        $this->payerIdentificationType = new StringVO($data->payer_identification_type);
        $this->payerIdentificationNumber = new StringVO($data->payer_identification_number);
        $this->notificationUrl = new UrlVO($data->notification_url);
        $this->createdAt = new DateVO($data->created_at);
        $this->updatedAt = $data->updated_at ? new StringVO($data->updated_at) : null;
    }

    public function getAllProperties(): array
    {
        return [
            'id' => $this->id->value,
            'status' => $this->status->value,
            'transaction_amount' => $this->transactionAmount->value,
            'installments' => $this->installments->value,
            'token' => $this->token->value,
            'payment_method_id' => $this->paymentMethodId->value,
            'payer' => [
                'entity_type' => $this->payerEntityType->value,
                'type' => $this->payerType->value,
                'email' => $this->payerEmail->value,
                'identification' => [
                    'type' => $this->payerIdentificationType->value,
                    'number' => $this->payerIdentificationNumber->value,
                ]
            ],
            'notification_url' => $this->notificationUrl->value,
            'created_at' => $this->createdAt->value,
            'updated_at' => $this->updatedAt->value ?? $this->updatedAt,
        ];
    }
}
