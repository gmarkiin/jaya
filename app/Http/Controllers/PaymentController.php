<?php

namespace App\Http\Controllers;

use App\Db\Payment\PaymentDb;
use App\Domain\Payment\Payment;
use App\DTO\PaymentCreateDTO;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class PaymentController extends BaseController
{
    public function create(Request $request): array
    {
        $paymentCreateDto = new PaymentCreateDTO($request->toArray());
        $payment = new Payment(new PaymentDb());
        $payment->createDTO = $paymentCreateDto;
        $payment->create();

        return [
            'id' => $payment->createDTO->id,
            'created_at' => $payment->createDTO->createdAt
        ];
    }
}
