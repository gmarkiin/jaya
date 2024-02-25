<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class InvalidPropertyValueException extends Exception
{
    /**
     * @throws InvalidPropertyValueException
     */
    public function __construct($message = "", $code = 422, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        throw $this;
    }
}
