<?php

namespace Payment\ValueObject;

use App\Domain\Payment\ValueObject\PaymentStatusVO;
use App\Enum\PaymentStatusEnum;
use App\Exceptions\InvalidPropertyValueException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Tests\TestCase;

class PaymentStatusVOTest extends TestCase
{
    /**
     * @throws InvalidPropertyValueException
     */
    public function testValidPaymentStatus(): void
    {
        $value = PaymentStatusEnum::PENDING->value;

        $this->assertSame($value, (new PaymentStatusVO($value))->value);
    }

    public function testInvalidType(): void
    {
        $status = 1231;

        $this->expectException(InvalidPropertyValueException::class);
        $this->expectExceptionMessage("The status '$status' need's be a string");

        new PaymentStatusVO($status);
    }

    public function testEmptyStatus(): void
    {
        $status = '';

        $this->expectException(InvalidPropertyValueException::class);
        $this->expectExceptionMessage('The status cannot be empty');

        new PaymentStatusVO($status);
    }

    public function testNotAvailableStatus(): void
    {
        $status = 'refund';

        $this->expectException(InvalidPropertyValueException::class);
        $this->expectExceptionMessage("The status '$status' isn't a available status");

        new PaymentStatusVO($status);
    }
}
