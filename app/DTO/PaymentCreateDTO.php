<?php
namespace App\DTO;

use App\Domain\Payment\ValueObject\PaymentStatusVO;
use App\Enum\PaymentStatusEnum;
use App\Exceptions\InvalidPropertyValueException;
use App\ValueObject\DateVO;
use App\ValueObject\TransactionAmountVO;
use App\ValueObject\IdVO;
use App\ValueObject\StringVO;
use App\ValueObject\InstallmentVO;
use App\ValueObject\UrlVO;
use Ramsey\Uuid\Uuid;

class PaymentCreateDTO
{
    public readonly TransactionAmountVO $transactionAmount;
    public readonly InstallmentVO $installments;
    public readonly StringVO $token;
    public readonly StringVO $paymentMethodId;
    public readonly StringVO $payerEmail;
    public readonly StringVO $payerIdentificationType;
    public readonly StringVO $payerIdentificationNumber;
    public readonly StringVO $payerEntityType;
    public readonly StringVO $payerType;
    public readonly IdVO $id;
    public readonly PaymentStatusVO $status;
    public readonly DateVO $createdAt;
    public readonly UrlVO $notificationUrl;

    private const PAYER_ENTITY_TYPE_DEFAULT = 'individual';
    private const PAYER_TYPE_DEFAULT = 'customer';
    private const NOTIFICATION_URL_DEFAULT = 'https://webhook.site/e3d32ab9-737a-4832-a5fa-f36a172cec53';

    /**
     * @throws InvalidPropertyValueException
     */
    public function __construct(array $requestData)
    {
        $payerData = $requestData['payer'];
        $payerIdentificationData = $payerData['identification'];

        $this->transactionAmount = new TransactionAmountVO($requestData['transaction_amount']);
        $this->installments = new InstallmentVO($requestData['installments']);
        $this->token = new StringVO($requestData['token']);
        $this->paymentMethodId = new StringVO($requestData['payment_method_id']);
        $this->payerEmail = new StringVO($payerData['email']);

        $this->payerIdentificationType = new StringVO($payerIdentificationData['type']);
        $this->payerIdentificationNumber = new StringVO($payerIdentificationData['number']);
        $this->payerEntityType = new StringVO(self::PAYER_ENTITY_TYPE_DEFAULT);
        $this->payerType = new StringVO(self::PAYER_TYPE_DEFAULT);

        $this->id = new IdVO(Uuid::uuid4()->toString());
        $this->status = new PaymentStatusVO(PaymentStatusEnum::PENDING->value);
        $this->createdAt = new DateVO(date('Y-m-d'));
        $this->notificationUrl = new UrlVO(self::NOTIFICATION_URL_DEFAULT);
    }
}
