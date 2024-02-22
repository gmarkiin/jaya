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
                'id' => $payment->createDTO->id,
                'transaction_amount' => $payment->createDTO->transactionAmount,
                'installments' => $payment->createDTO->installments,
                'token' => $payment->createDTO->token,
                'payment_method_id' => $payment->createDTO->paymentMethodId,
                'payer_entity_type' => $payment->createDTO->payerEntityType,
                'payer_type' => $payment->createDTO->payerType,
                'payer_email' => $payment->createDTO->payerEmail,
                'payer_identification_type' => $payment->createDTO->payerIdentificationType,
                'payer_identification_number' => $payment->createDTO->payerIdentificationNumber,
                'notification_url' => $payment->notificationUrl,
                'created_at' => $payment->createDTO->createdAt,
                'status' => $payment->createDTO->status
            ]);

        if (!$record) {
            throw new RuntimeException('Failed insert');
        }
    }
}
