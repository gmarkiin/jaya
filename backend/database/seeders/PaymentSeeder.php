<?php

namespace Database\Seeders;

use App\Enum\PaymentStatusEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentSeeder extends Seeder
{
    /**
     */
    public function run(): void
    {
        DB::table('payments')->insert([
            'id' => Str::uuid(),
            'transaction_amount' => $this->randFloat(),
            'installments' => 2,
            'token' => Str::random(32),
            'payment_method_id' => 'master',
            'payer_entity_type' => 'individual',
            'payer_type' => 'costumer',
            'payer_email' => Str::random(12) . '@example.com',
            'payer_identification_type' => 'CPF',
            'payer_identification_number' => '84353709097',
            'notification_url' => 'https://webhook.site/#!/view/e3d3/181fcbdc-8736-479a-b782-6d97f183df49/1',
            'created_at' => date('Y-m-d'),
            'updated_at' => null,
            'status' => PaymentStatusEnum::PENDING->value,
        ]);
    }

    function randFloat(): float
    {
        $max = 530;
        $min = 100;
        $randomNumber = mt_rand() / mt_getrandmax() * ($max - $min) + $min;

        return round($randomNumber, 1);
    }
}
