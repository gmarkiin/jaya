<?php

namespace Payment;

use App\Db\Payment\PaymentDb;
use App\Domain\Payment\Payment;
use App\DTO\PaymentCreateDTO;
use App\Exceptions\InvalidPropertyValueException;
use App\Exceptions\PersistenceException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @throws InvalidPropertyValueException
     */
    public function testPaymentCreateSuccessful()
    {
        $data = [
            'transaction_amount' => 321.32,
            'installments' => 2,
            'token' => 'ae4e50b2a8f3h6d9f2c3a4b5d6e7f8g9',
            'payment_method_id' => 'master',
            'payer' => [
                'email' => "example_random@gmail.com",
                'identification' => [
                    'type' => "CPF",
                    'number' => "12345678909",
                ]
            ]
        ];

        $paymentCreateDto = new PaymentCreateDTO($data);
        $payment = new Payment(new PaymentDb());
        $payment->createDTO = $paymentCreateDto;
        $payment->create();

        $this->assertDatabaseHas('payments', [
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
    }

    /**
     * @throws PersistenceException
     * @throws InvalidPropertyValueException
     */
    public function testPaymentCreateFailed()
    {
        DB::shouldReceive('table')->with('payments')->once()->andReturnSelf();
        DB::shouldReceive('insert')->once()->andReturn(false);

        $data = [
            'transaction_amount' => 321.32,
            'installments' => 2,
            'token' => 'ae4e50b2a8f3h6d9f2c3a4b5d6e7f8g9',
            'payment_method_id' => 'master',
            'payer' => [
                'email' => "example_random@gmail.com",
                'identification' => [
                    'type' => "CPF",
                    'number' => "12345678909",
                ]
            ]
        ];

        $paymentCreateDto = new PaymentCreateDTO($data);
        $payment = new Payment(new PaymentDb());
        $payment->createDTO = $paymentCreateDto;

        $this->expectException(PersistenceException::class);
        $this->expectExceptionMessage('Failed to insert payment');

        $payment->create();
    }
}
