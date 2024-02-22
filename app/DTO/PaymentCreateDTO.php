<?php
namespace App\DTO;

use App\Enum\PaymentStatusEnum;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

class PaymentCreateDTO
{
    private readonly array $requestData;
    public readonly float $transactionAmount;
    public readonly int $installments;
    public readonly string $token;
    public readonly string $paymentMethodId;
    public readonly string $payerEmail;
    public readonly string $payerIdentificationType;
    public readonly string $payerIdentificationNumber;
    public readonly string $payerEntityType;
    public readonly string $payerType;
    public readonly string $id;
    public readonly string $status;
    public readonly string $createdAt;

    private const TRANSACTION_AMOUNT_FIELD = 'transaction_amount';
    private const INSTALLMENTS_FIELD = 'installments';
    private const TOKEN_FIELD = 'token';
    private const PAYMENT_METHOD_ID_FIELD = 'payment_method_id';
    private const PAYER_FIELD = 'payer';
    private const PAYER_EMAIL_FIELD = 'email';
    private const PAYER_IDENTIFICATION_FIELD = 'identification';
    private const PAYER_IDENTIFICATION_TYPE_FIELD = 'type';
    private const PAYER_IDENTIFICATION_NUMBER_FIELD = 'number';
    private const PAYER_ENTITY_TYPE = 'individual';
    private const PAYER_TYPE = 'customer';

    public function __construct(array $requestData)
    {
        $this->requestData = $requestData;
        $this->validateData();
        $this->build();
    }

    private function validateData(): void
    {
        if (!is_float($this->requestData[self::TRANSACTION_AMOUNT_FIELD])) {
            $this->throwInvalidValueException();
        }

        if (!is_int($this->requestData[self::INSTALLMENTS_FIELD])) {
            $this->throwInvalidValueException();
        }

        if (!is_string($this->requestData[self::TOKEN_FIELD])) {
            $this->throwInvalidValueException();
        }

        if (!is_string($this->requestData[self::PAYMENT_METHOD_ID_FIELD])){
            $this->throwInvalidValueException();
        }

        $payerData = $this->requestData[self::PAYER_FIELD];
        if (!is_string($payerData[self::PAYER_EMAIL_FIELD])) {
            $this->throwInvalidValueException();
        }

        $payerIdentificationData = $payerData[self::PAYER_IDENTIFICATION_FIELD];
        if (!is_string($payerIdentificationData[self::PAYER_IDENTIFICATION_TYPE_FIELD])) {
            $this->throwInvalidValueException();
        }


        if (!is_string($payerIdentificationData[self::PAYER_IDENTIFICATION_NUMBER_FIELD])) {
            $this->throwInvalidValueException();
        }

    }

    private function throwInvalidValueException(): void
    {
        $message = 'Invalid payment provided.The possible reasons are:' .
            'A field of the provided payment was null or with invalid values';

        throw new HttpResponseException(
            response()->json([
                'message' => $message,
            ], Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }

    private function build(): void
    {
        $payerData = $this->requestData[self::PAYER_FIELD];
        $payerIdentificationData = $payerData[self::PAYER_IDENTIFICATION_FIELD];

        $this->transactionAmount = $this->requestData[self::TRANSACTION_AMOUNT_FIELD];
        $this->installments = $this->requestData[self::INSTALLMENTS_FIELD];
        $this->token = $this->requestData[self::TOKEN_FIELD];
        $this->paymentMethodId = $this->requestData[self::PAYMENT_METHOD_ID_FIELD];
        $this->payerEmail = $payerData[self::PAYER_EMAIL_FIELD];

        $this->payerIdentificationType = $payerIdentificationData[self::PAYER_IDENTIFICATION_TYPE_FIELD];
        $this->payerIdentificationNumber = $payerIdentificationData[self::PAYER_IDENTIFICATION_NUMBER_FIELD];
        $this->payerEntityType = self::PAYER_ENTITY_TYPE;
        $this->payerType = self::PAYER_TYPE;

        $this->id = Uuid::uuid4()->toString();
        $this->status = PaymentStatusEnum::PENDING->value;
        $this->createdAt = Carbon::now()->format('Y-m-d');
    }
}
