<?php

namespace App\Http\Controllers;

use App\Db\Payment\PaymentDb;
use App\Domain\Payment\Payment;
use App\Domain\Payment\ValueObject\DateVO;
use App\Domain\Payment\ValueObject\IdVO;
use App\Domain\Payment\ValueObject\PaymentStatusVO;
use App\DTO\PaymentCreateDTO;
use App\DTO\PaymentStatusUpdateDTO;
use App\Enum\PaymentStatusEnum;
use App\Exceptions\InvalidPropertyValueException;
use App\Exceptions\InvalidRequestPayload;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends BaseController
{
    /**
     * @throws InvalidPropertyValueException
     * @throws InvalidRequestPayload
     */
    public function createPayment(Request $request): JsonResponse
    {
        $this->validatePayload($request->toArray());
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
            )->setStatusCode(Response::HTTP_CREATED);
    }

    public function listAllPayments(): JsonResponse
    {
        $paymentsList = (new Payment(new PaymentDb()))->listAllPayments();

        return response()
            ->json($paymentsList)->setStatusCode(Response::HTTP_ACCEPTED);
    }


    /**
     * @throws InvalidPropertyValueException
     */
    public function listPayment(string $id): JsonResponse
    {
        $id = new IdVO($id);
        $paymentsList = (new Payment(new PaymentDb()))->listPaymentById($id);

        return response()
            ->json($paymentsList)->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @throws InvalidPropertyValueException
     */
    public function confirmPayment(string $id): JsonResponse
    {
        $payment = (new Payment(new PaymentDb()));
        $payment->paymentStatusUpdateDTO = new PaymentStatusUpdateDTO(
            new IdVO($id),
            new PaymentStatusVO(PaymentStatusEnum::PAID->value),
            new DateVO(date('Y-m-d'))
        );

        $payment->confirmPaymentById();

        return response()
            ->json(
                [
                    'status' => PaymentStatusEnum::PAID->name
                ]
            )->setStatusCode(Response::HTTP_NO_CONTENT);
    }

    /**
     * @throws InvalidPropertyValueException
     */
    public function cancelPayment(string $id): JsonResponse
    {
        $payment = (new Payment(new PaymentDb()));
        $payment->paymentStatusUpdateDTO = new PaymentStatusUpdateDTO(
            new IdVO($id),
            new PaymentStatusVO(PaymentStatusEnum::CANCELED->value),
            new DateVO(date('Y-m-d'))
        );
        $payment->cancelPaymentById();

        return response()
            ->json(
                [
                    'status' => PaymentStatusEnum::CANCELED->name
                ]
            )->setStatusCode(Response::HTTP_NO_CONTENT);
    }

    /**
     * @throws InvalidRequestPayload
     */
    private function validatePayload(array $payload): void
    {
        if (empty($payload)) {
            throw new InvalidRequestPayload();
        }
    }
}
