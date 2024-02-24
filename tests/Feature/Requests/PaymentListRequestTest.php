<?php

namespace Requests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PaymentListRequestTest extends TestCase
{
    use RefreshDatabase;

    public function testPaymentListById()
    {
        DB::table('payments')
            ->insert([
                'id' => '290c4906-c031-433e-bb44-48d4a1f611e6',
                'transaction_amount' => '213.2',
                'installments' => '2',
                'token' => 'au1e62b2a8f3h6d9f2c3a4b5d6e7f8g3',
                'payment_method_id' => 'master',
                'payer_entity_type' => 'individual',
                'payer_type' => 'customer',
                'payer_email' => 'teste@example.com',
                'payer_identification_type' => 'cpf',
                'payer_identification_number' => '12345678909',
                'notification_url' => 'https://webhook.site/e3d32ab9-737a-4832-a5fa-f36a172cec53',
                'created_at' => '2024-01-01',
                'status' => 'pending'
            ]);
        $response = $this->json('GET', '/api/rest/payments/290c4906-c031-433e-bb44-48d4a1f611e6');

        $response->assertOk();
        $this->assertDatabaseHas('payments', [
            'id' => '290c4906-c031-433e-bb44-48d4a1f611e6'
        ]);
    }

    public function testPaymentListWithoutItem()
    {
        $response = $this->json('GET', '/api/rest/payments/2c08d3b0-600d-45bd-b3c7-b63f8e6fc389');

        $response->assertNotFound();
        $response->json(['message' => 'Payment not found with the specified id']);
    }
}
