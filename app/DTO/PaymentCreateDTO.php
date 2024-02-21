<?php
namespace App\DTO;

use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class PaymentCreateDTO
{
    public readonly string $transactionAmount;
    public readonly int $installments;
    public readonly string $token;
    public readonly string $paymentMethodId;
    public readonly string $payerEmail;
    public readonly string $payerIdentificationType;
    public readonly string $payerIdentificationNumber;

    private const REQUEST_BASE = [
        'transaction_amount' => null,
        'installments' => null,
        'token' => null,
        'payment_method_id' => null,
        'payer' => [
            'email' => null,
            'identification' => [
                'type' => null,
                'number' => null
            ],
        ],
    ];

    public function __construct(array $requestData)
    {
        $this->verifyBaseFieldsExists($requestData);
        $this->validateData($requestData);
        $this->build();
    }

    private function verifyBaseFieldsExists(array $requestData): void
    {
//        dd(array_keys($requestData));
    }

    private function validateData(array $requestData): void
    {
        if (empty($requestData)) {
            $message = 'Payment not provided in the request body';

            throw new HttpResponseException(
                response()->json([
                    'message' => $message,
                ], Response::HTTP_BAD_REQUEST)
            );
        }



    }

    private function build()
    {
    }
}
