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

/**
 * @OA\Info(
 *     title="Jaya Test",
 *     version="0.1"
 * )
 */
class PaymentController extends BaseController
{
    /**
     * @OA\Post(
     *     path="/api/payment",
     *     summary="Make a payment",
     *     tags={"Payment"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dados do pagamento",
     *         @OA\JsonContent(
     *             @OA\Property(property="transaction_amount", type="number", format="float", example="245.90"),
     *             @OA\Property(property="installments", type="integer", example="3"),
     *             @OA\Property(property="token", type="string", example="ae4e50b2a8f3h6d9f2c3a4b5d6e7f8g9"),
     *             @OA\Property(property="payment_method_id", type="string", example="master"),
     *             @OA\Property(
     *                 property="payer",
     *                 type="object",
     *                 @OA\Property(property="email", type="string", example="example_random@gmail.com"),
     *                 @OA\Property(
     *                     property="identification",
     *                     type="object",
     *                     @OA\Property(property="type", type="string", example="CPF"),
     *                     @OA\Property(property="number", type="string", example="12345678909")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OK",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                  @OA\Property(property="id", type="string", example="eda2d5f0-dbfe-4093-84c2-55ab47febe0f"),
     *                  @OA\Property(property="created_at", type="string", example="2024-02-25"),
     *                     example={
     *                         "id": "eda2d5f0-dbfe-4093-84c2-55ab47febe0f",
     *                         "created_at": "2024-02-25",
     *                     }
     *                 )
     *             )
     *         }
     *     ),
     *
     *     @OA\Response(
     *         response="400",
     *         description="Request without payload",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(property="message",type="string", example="Payment not provided in the request body"),
     *                     example={
     *                         "message": "Payment not provided in the request body",
     *                     }
     *                 )
     *             )
     *         }
     *     ),
     *
     *     @OA\Response(
     * *         response="422",
     * *         description="Request with invalid field or value",
     * *         content={
     * *             @OA\MediaType(
     * *                 mediaType="application/json",
     * *                 @OA\Schema(
     * *                     @OA\Property(property="message",type="string", example="Invalid payment provided.The possible reasons are:A field of the provided payment was null or with invalid values"),
     * *                     example={
     * *                         "message": "Invalid payment provided.The possible reasons are:A field of the provided payment was null or with invalid values",
     * *                     }
     * *                 )
     * *             )
     * *         }
     * *     ),
     * )
     * @throws InvalidRequestPayload
     * @throws InvalidPropertyValueException
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

    /**
     * @OA\Get(
     *     path="/api/rest/payments",
     *     summary="List all payments",
     *     tags={"Payment"},
     *     @OA\Response(
     *         response=202,
     *         description="Success with items",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="string", example="10763b2b-5034-4cc0-8cb2-c5926439158c"),
     *                 @OA\Property(property="status", type="string", example="pending"),
     *                 @OA\Property(property="transaction_amount", type="number", format="float", example=245.9),
     *                 @OA\Property(property="installments", type="integer", example=3),
     *                 @OA\Property(property="token", type="string", example="ae4e50b2a8f3h6d9f2c3a4b5d6e7f8g9"),
     *                 @OA\Property(property="payment_method_id", type="string", example="master"),
     *                 @OA\Property(
     *                     property="payer",
     *                     type="object",
     *                     @OA\Property(property="entity_type", type="string", example="individual"),
     *                     @OA\Property(property="type", type="string", example="customer"),
     *                     @OA\Property(property="email", type="string", example="example_random@gmail.com"),
     *                     @OA\Property(
     *                         property="identification",
     *                         type="object",
     *                         @OA\Property(property="type", type="string", example="CPF"),
     *                         @OA\Property(property="number", type="string", example="12345678909")
     *                     )
     *                 ),
     *                 @OA\Property(property="notification_url", type="string", example="https://webhook.site/e3d32ab9-737a-4832-a5fa-f36a172cec53"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-02-25"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example=null)
     *             )
     *         )
     *     )
     * )
     */
    public function listAllPayments(): JsonResponse
    {
        $paymentsList = (new Payment(new PaymentDb()))->listAllPayments();

        return response()
            ->json($paymentsList)->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * @OA\Get(
     *     path="/api/rest/payments/{id}}",
     *     summary="List a payment by ID",
     *     tags={"Payment"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Payment ID",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sucesso com itens",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="string", example="10763b2b-5034-4cc0-8cb2-c5926439158c"),
     *                 @OA\Property(property="status", type="string", example="pending"),
     *                 @OA\Property(property="transaction_amount", type="number", format="float", example=245.9),
     *                 @OA\Property(property="installments", type="integer", example=3),
     *                 @OA\Property(property="token", type="string", example="ae4e50b2a8f3h6d9f2c3a4b5d6e7f8g9"),
     *                 @OA\Property(property="payment_method_id", type="string", example="master"),
     *                 @OA\Property(
     *                     property="payer",
     *                     type="object",
     *                     @OA\Property(property="entity_type", type="string", example="individual"),
     *                     @OA\Property(property="type", type="string", example="customer"),
     *                     @OA\Property(property="email", type="string", example="example_random@gmail.com"),
     *                     @OA\Property(
     *                         property="identification",
     *                         type="object",
     *                         @OA\Property(property="type", type="string", example="CPF"),
     *                         @OA\Property(property="number", type="string", example="12345678909")
     *                     )
     *                 ),
     *                 @OA\Property(property="notification_url", type="string", example="https://webhook.site/e3d32ab9-737a-4832-a5fa-f36a172cec53"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-02-25"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example=null)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Payment not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Payment not found with the specified id")
     *         )
     *     )
     * )
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
     * @OA\Patch(
     *     path="/api/rest/payments/{id}",
     *     summary="Confirm a payment by ID",
     *     tags={"Payment"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the payment",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=202,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="PAID")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Bank slip not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Bank slip not found with the specified id")
     *         )
     *     )
     * )
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
     * @OA\Delete(
     *     path="/api/rest/payments/{id}",
     *     summary="Cancel a payment by ID",
     *     tags={"Payment"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the payment",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=202,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="CANCELED")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Bank slip not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Payment not found with the specified id")
     *         )
     *     )
     * )
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
