<?php

namespace App\Domain\Payment\ValueObject;

use App\Exceptions\InvalidPropertyValueException;
use Ramsey\Uuid\Uuid;

class IdVO
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
            throw new InvalidPropertyValueException("The ID '$this->value' need's be a string");
        }

        if (!Uuid::isValid($this->value)) {
            throw new InvalidPropertyValueException("The ID '$this->value' isn't a UUID");
        }
    }
}
