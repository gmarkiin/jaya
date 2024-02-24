<?php

namespace App\Http\Controllers;

use App\Db\Payment\PaymentDb;
use App\Domain\Payment\Payment;
use App\DTO\PaymentCreateDTO;
use App\Http\Requests\PaymentCreateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class PaymentController extends BaseController
{
    public function createPayment(PaymentCreateRequest $request): JsonResponse
    {
        $paymentCreateDto = new PaymentCreateDTO($request->toArray());
        $payment = new Payment(new PaymentDb());
        $payment->createDTO = $paymentCreateDto;
        $payment->create();

        return response()
            ->json(
                [
                    'id' => $payment->createDTO->id->value,
                    'created_at' => $payment->createDTO->createdAt->value
                ]
            )->setStatusCode(201);
    }

    public function listAllPayments(): JsonResponse
    {
        $paymentsList = (new Payment(new PaymentDb()))->listAllPayments();

        return response()
            ->json($paymentsList)->setStatusCode(200);
    }


    public function listPayment(string $id): JsonResponse
    {
        $paymentsList = (new Payment(new PaymentDb()))->listPaymentById($id);

        return response()
            ->json($paymentsList)->setStatusCode(200);
    }
}
