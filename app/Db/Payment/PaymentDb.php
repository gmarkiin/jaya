<?php

namespace App\Db\Payment;

use App\Domain\Payment\Payment;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class PaymentDb implements PaymentPersistenceInterface
{
    private const PAYMENTS_TABLE = 'payments';

    public function create(Payment $payment): void
    {
        $record = DB::table(self::PAYMENTS_TABLE)
            ->insert([
                'id' => $payment->createDTO->id->value,
                'transaction_amount' => $payment->createDTO->transactionAmount->value,
                'installments' => $payment->createDTO->installments->value,
                'token' => $payment->createDTO->token->value,
                'payment_method_id' => $payment->createDTO->paymentMethodId->value,
                'payer_entity_type' => $payment->createDTO->payerEntityType->value,
                'payer_type' => $payment->createDTO->payerType->value,
                'payer_email' => $payment->createDTO->payerEmail->value,
                'payer_identification_type' => $payment->createDTO->payerIdentificationType->value,
                'payer_identification_number' => $payment->createDTO->payerIdentificationNumber->value,
                'notification_url' => $payment->notificationUrl,
                'created_at' => $payment->createDTO->createdAt->value,
                'status' => $payment->createDTO->status->value
            ]);

        if (!$record) {
            throw new RuntimeException('Failed insert');
        }
    }
}
