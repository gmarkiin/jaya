<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class BankslipNotFoundException extends Exception
{
    /**
     * @throws BankslipNotFoundException
     */
    public function __construct($message = "Bank slip not found with the specified id", $code = 404, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        throw $this;
    }
}
