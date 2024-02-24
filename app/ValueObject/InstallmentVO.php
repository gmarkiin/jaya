<?php

namespace App\ValueObject;

use App\Exceptions\InvalidPropertyValueException;

class InstallmentVO
{
    /**
     * @throws InvalidPropertyValueException
     */
    public function __construct(public readonly mixed $value)
    {
        $this->validateValue();
    }

    /**
     * @throws InvalidPropertyValueException
     */
    private function validateValue(): void
    {
        if (!is_int($this->value)) {
            throw new InvalidPropertyValueException("The installment need's be a integer");
        }

        if ($this->value <= 0) {
            throw new InvalidPropertyValueException('The installment cannot be less than 0');
        }
    }
}
