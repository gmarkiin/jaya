<?php

namespace App\Domain\Payment\ValueObject;

use App\Exceptions\InvalidPropertyValueException;

class StringVO
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
        if (!is_string($this->value)) {
            throw new InvalidPropertyValueException("The value '$this->value' need's be a string");
        }

        if (empty($this->value)) {
            throw new InvalidPropertyValueException('The value cannot be empty');
        }
    }
}
