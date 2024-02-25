<?php

namespace App\Domain\Payment\ValueObject;

use App\Enum\PaymentStatusEnum;
use App\Exceptions\InvalidPropertyValueException;

class PaymentStatusVO
{
    /**
     * @throws InvalidPropertyValueException
     */
    public function __construct(public readonly mixed $value)
    {
        $this->validateStatus();
    }

    /**
     * @throws InvalidPropertyValueException
     */
    private function validateStatus(): void
    {
        if (empty($this->value)) {
            throw new InvalidPropertyValueException('The status cannot be empty');
        }

        if (!is_string($this->value)) {
            throw new InvalidPropertyValueException("The status '$this->value' need's be a string");
        }

        if (!in_array($this->value, PaymentStatusEnum::availableStatus())) {
            throw new InvalidPropertyValueException("The status '$this->value' isn't a available status");
        }
    }
}
