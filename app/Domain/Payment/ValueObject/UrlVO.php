<?php

namespace App\Domain\Payment\ValueObject;

use App\Exceptions\InvalidPropertyValueException;

class UrlVO
{
    /**
     * @throws InvalidPropertyValueException
     */
    public function __construct(public readonly mixed $value)
    {
        $this->validateUrl();
    }

    /**
     * @throws InvalidPropertyValueException
     */
    private function validateUrl(): void
    {
        if (!is_string($this->value)) {
            throw new InvalidPropertyValueException("The url '$this->value' need's be a string");
        }

        $pattern = '/^(https?):\/\/([^\s\/?.#]+\.?)+(\/\S*)?$/i';
        if (!preg_match($pattern, $this->value)) {
            throw new InvalidPropertyValueException("The url '$this->value' isn't a UUID");
        }
    }
}
