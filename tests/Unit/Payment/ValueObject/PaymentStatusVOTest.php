<?php

namespace Payment\ValueObject;

use App\Domain\Payment\ValueObject\PaymentStatusVO;
use App\Enum\PaymentStatusEnum;
use Illuminate\Http\Exceptions\HttpResponseException;
use Tests\TestCase;

class PaymentStatusVOTest extends TestCase
{
    public function testValidPaymentStatusVO(): void
    {
        $value = PaymentStatusEnum::PENDING->value;
        $paymentStatusVO = new PaymentStatusVO($value);

        $this->assertSame($value, $paymentStatusVO->value);
    }

    public function testInvalidPaymentStatusVO(): void
    {
        $value = 'approved';

        $this->expectException(HttpResponseException::class);

        new PaymentStatusVO($value);
    }
}
