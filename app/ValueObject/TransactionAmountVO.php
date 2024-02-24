<?php

namespace App\ValueObject;

use App\Exceptions\InvalidPropertyValueException;

class TransactionAmountVO
{
    /**
     * @throws InvalidPropertyValueException
     */
    public function __construct(public readonly mixed $value)
    {
        $this->validateAmount();
    }

    /**
     * @throws InvalidPropertyValueException
     */
    private function validateAmount(): void
    {
        if ($this->value <= 0) {
            throw new InvalidPropertyValueException('The transaction value cannot be less than 0');
        }

        if (!is_float($this->value)) {
            throw new InvalidPropertyValueException("The transaction value need's be a float");
        }
    }
}
