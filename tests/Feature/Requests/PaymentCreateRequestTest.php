<?php

namespace Requests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentCreateRequestTest extends TestCase
{
    use RefreshDatabase;

    public function testPaymentCreateSuccessful()
    {
        $response = $this
            ->json('POST', '/api/rest/payments', [
                'transaction_amount' => 321.32,
                'installments' => 2,
                'token' => 'ae4e50b2a8f3h6d9f2c3a4b5d6e7f8g9',
                'payment_method_id' => 'master',
                'payer' => [
                    'email' => "example_random@gmail.com",
                    'identification' => [
                        'type' =>  "CPF",
                        'number' =>  "12345678909",
                    ]
                ]
            ]);

        $response->assertCreated();

        $this->assertDatabaseHas('payments', [
            'token' => 'ae4e50b2a8f3h6d9f2c3a4b5d6e7f8g9'
        ]);
    }

    public function testPaymentCreateFailed()
    {
        $response = $this
            ->json('POST', '/api/rest/payments', [
                'transaction_amount' => 321.32,
                'token' => 'ae4e50b2a8f3h6d9f2c3a4b5d6e7f8g9',
                'payment_method_id' => 'master',
                'payer' => [
                    'email' => "example_random@gmail.com",
                    'identification' => [
                        'type' =>  "CPF",
                        'number' =>  "12345678909",
                    ]
                ]
            ]);

        $response->assertBadRequest();
        $response->assertJson(
            [
                'message' => 'Payment not provided in the request body'
            ]
        );

    }
}
