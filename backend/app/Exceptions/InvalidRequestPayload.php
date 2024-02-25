<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class InvalidRequestPayload extends Exception
{
    /**
     * @throws InvalidRequestPayload
     */
    public function __construct(
        $message = "Payment not provided in the request body",
        $code = 400,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        throw $this;
    }
}
