<?php

namespace App\ValueObject;

use App\Exceptions\InvalidPropertyValueException;
use DateTime;

class DateVO
{
    /**
     * @throws InvalidPropertyValueException
     */
    public function __construct(public readonly mixed $value)
    {
        $this->validateDate();
    }

    /**
     * @throws InvalidPropertyValueException
     */
    private function validateDate(): void
    {
        if (!is_string($this->value)) {
            throw new InvalidPropertyValueException("The date need's be a string");
        }

        if (empty($this->value)) {
            throw new InvalidPropertyValueException('The date cannot be empty');
        }

        $date = DateTime::createFromFormat('Y-m-d', $this->value);
        if (!$date || $date->format('Y-m-d') !== $this->value) {
            throw new InvalidPropertyValueException("Invalid date format. Date should be in the format 'YYYY-MM-DD'");
        }
    }
}
