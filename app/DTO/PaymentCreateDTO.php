<?php
namespace App\DTO;

use App\Domain\Payment\ValueObject\PaymentStatusVO;
use App\Enum\PaymentStatusEnum;
use App\ValueObject\FloatVO;
use App\ValueObject\IdVO;
use App\ValueObject\IntegerVO;
use App\ValueObject\StringVO;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class PaymentCreateDTO
{
    private readonly array $requestData;
    public readonly FloatVO $transactionAmount;
    public readonly IntegerVO $installments;
    public readonly StringVO $token;
    public readonly StringVO $paymentMethodId;
    public readonly StringVO $payerEmail;
    public readonly StringVO $payerIdentificationType;
    public readonly StringVO $payerIdentificationNumber;
    public readonly StringVO $payerEntityType;
    public readonly StringVO $payerType;
    public readonly IdVO $id;
    public readonly PaymentStatusVO $status;
    public readonly StringVO $createdAt;

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
        $this->build();
    }

    private function build(): void
    {
        $payerData = $this->requestData[self::PAYER_FIELD];
        $payerIdentificationData = $payerData[self::PAYER_IDENTIFICATION_FIELD];

        $this->transactionAmount = new FloatVO($this->requestData[self::TRANSACTION_AMOUNT_FIELD]);
        $this->installments = new IntegerVO($this->requestData[self::INSTALLMENTS_FIELD]);
        $this->token = new StringVO($this->requestData[self::TOKEN_FIELD]);
        $this->paymentMethodId = new StringVO($this->requestData[self::PAYMENT_METHOD_ID_FIELD]);
        $this->payerEmail = new StringVO($payerData[self::PAYER_EMAIL_FIELD]);

        $this->payerIdentificationType = new StringVO($payerIdentificationData[self::PAYER_IDENTIFICATION_TYPE_FIELD]);
        $this->payerIdentificationNumber = new StringVO($payerIdentificationData[self::PAYER_IDENTIFICATION_NUMBER_FIELD]);
        $this->payerEntityType = new StringVO(self::PAYER_ENTITY_TYPE);
        $this->payerType = new StringVO(self::PAYER_TYPE);

        $this->id = new IdVO(Uuid::uuid4()->toString());
        $this->status = new PaymentStatusVO(PaymentStatusEnum::PENDING->value);
        $this->createdAt = new StringVO(Carbon::now()->format('Y-m-d'));
    }
}
