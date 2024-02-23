<?php

namespace Requests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class PaymentsListRequestTest extends TestCase
{
    use RefreshDatabase;

    public function testPaymentsListWithItems()
    {
        Artisan::call('db:seed', ['--class' => 'PaymentSeeder']);
        $response = $this->json('GET', '/api/rest/payments');

        $response->assertOk();
        $this->assertDatabaseCount('payments', 1);
    }

    public function testPaymentsListWithoutItems()
    {
        $response = $this->json('GET', '/api/rest/payments');

        $response->assertOk();
        $response->json([]);
    }
}
