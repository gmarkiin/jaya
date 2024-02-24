<?php

namespace App\Db\Payment;

use App\Domain\Payment\Payment;
use App\DTO\PaymentListDTO;
use App\Enum\PaymentStatusEnum;
use App\ValueObject\DateVO;
use App\ValueObject\StringVO;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

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
                'notification_url' => $payment->createDTO->notificationUrl->value,
                'created_at' => $payment->createDTO->createdAt->value,
                'status' => $payment->createDTO->status->value
            ]);

        if (!$record) {
            throw new RuntimeException('Failed insert');
        }
    }

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

    public function listPaymentById(string $paymentId, Payment $payment): void
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
            ->where(['id' => $paymentId])
            ->get()
            ->toArray();

        if (empty($record)) {
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Payment not found with the specified id',
                ], Response::HTTP_NOT_FOUND)
            );
        }

        $payment->paymentList = new PaymentListDTO((object)$record[0]);
    }

    public function confirmPaymentById(string $paymentId, Payment $payment): void
    {
        $record = DB::table(self::PAYMENTS_TABLE)
            ->where('id', $paymentId)
            ->update(
                [
                    'status' => PaymentStatusEnum::PAID->value,
                    'updated_at' => date('Y-m-d')
                ]
            );


        if (!$record) {
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Bank slip not found with the specified id',
                ], Response::HTTP_NOT_FOUND)
            );
        }
    }

    public function cancelPaymentById(string $paymentId, Payment $payment): void
    {
        $record = DB::table(self::PAYMENTS_TABLE)
            ->where('id', $paymentId)
            ->update(
                [
                    'status' => PaymentStatusEnum::CANCELED->value,
                    'updated_at' => date('Y-m-d'),
                ]
            );

        if (!$record) {
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Payment not found with the specified id',
                ], Response::HTTP_NOT_FOUND)
            );
        }
    }
}
