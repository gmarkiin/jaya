<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class PersistenceException extends Exception
{
    /**
     * @throws PersistenceException
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        throw $this;
    }
}
