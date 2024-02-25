<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class PaymentNotFoundException extends Exception
{
    /**
     * @throws PaymentNotFoundException
     */
    public function __construct(
        $message = "Payment not found with the specified id",
        $code = 404,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        throw $this;
    }
}
