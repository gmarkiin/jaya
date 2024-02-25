<?php

namespace App\Db\Payment;

use App\Domain\Payment\Payment;
use App\Domain\Payment\ValueObject\IdVO;
use App\DTO\PaymentListDTO;
use App\Exceptions\BankslipNotFoundException;
use App\Exceptions\InvalidPropertyValueException;
use App\Exceptions\PaymentNotFoundException;
use App\Exceptions\PersistenceException;
use Illuminate\Support\Facades\DB;

class PaymentDb implements PaymentPersistenceInterface
{
    private const PAYMENTS_TABLE = 'payments';

    /**
     * @throws PersistenceException
     */
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
                'notification_url' => $payment->createDTO->notificationUrl->value,
                'created_at' => $payment->createDTO->createdAt->value,
                'status' => $payment->createDTO->status->value
            ]);

        if (!$record) {
            throw new PersistenceException('Failed to insert payment');
        }
    }

    /**
     * @throws InvalidPropertyValueException
     */
    public function listAllPayments(Payment $payment): void
    {
        $records = DB::table(self::PAYMENTS_TABLE)
            ->select([
                'id',
                'transaction_amount',
                'installments',
                'token',
                'payment_method_id',
                'payer_entity_type',
                'payer_type',
                'payer_email',
                'payer_identification_type',
                'payer_identification_number',
                'notification_url',
                'created_at',
                'updated_at',
                'status',
            ])
            ->get()
            ->all();

        $payments = [];
        foreach ($records as $record) {
            $payments[] = new PaymentListDTO($record);
        }

        $payment->paymentsList = $payments;
    }

    /**
     * @throws PaymentNotFoundException
     * @throws InvalidPropertyValueException
     */
    public function listPaymentById(IdVO $paymentId, Payment $payment): void
    {
        $record = DB::table(self::PAYMENTS_TABLE)
            ->select([
                'id',
                'transaction_amount',
                'installments',
                'token',
                'payment_method_id',
                'payer_entity_type',
                'payer_type',
                'payer_email',
                'payer_identification_type',
                'payer_identification_number',
                'notification_url',
                'created_at',
                'updated_at',
                'status',
            ])
            ->where(['id' => $paymentId->value])
            ->get()
            ->toArray();

        if (empty($record)) {
            throw new PaymentNotFoundException();
        }

        $payment->paymentList = new PaymentListDTO((object)$record[0]);
    }

    /**
     * @throws BankslipNotFoundException
     */
    public function confirmPaymentById(Payment $payment): void
    {
        $record = DB::table(self::PAYMENTS_TABLE)
            ->where('id', $payment->paymentStatusUpdateDTO->id->value)
            ->update(
                [
                    'status' => $payment->paymentStatusUpdateDTO->status->value,
                    'updated_at' => $payment->paymentStatusUpdateDTO->updatedDate->value
                ]
            );


        if (!$record) {
            throw new BankslipNotFoundException();
        }
    }

    /**
     * @throws PaymentNotFoundException
     */
    public function cancelPaymentById(Payment $payment): void
    {
        $record = DB::table(self::PAYMENTS_TABLE)
            ->where('id', $payment->paymentStatusUpdateDTO->id->value)
            ->update(
                [
                    'status' => $payment->paymentStatusUpdateDTO->status->value,
                    'updated_at' => $payment->paymentStatusUpdateDTO->updatedDate->value
                ]
            );

        if (!$record) {
            throw new PaymentNotFoundException();
        }
    }
}
