<?php

namespace App\ValueObject;

use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class IntegerVO
{
    public function __construct(public readonly mixed $value)
    {
        $this->validateValue();
    }

    private function validateValue(): void
    {
        if (!is_int($this->value) || $this->value <= 0) {
            $message = 'Invalid payment provided.The possible reasons are:' .
                'A field of the provided payment was null or with invalid values';

            throw new HttpResponseException(
                response()->json([
                    'message' => $message,
                ], Response::HTTP_UNPROCESSABLE_ENTITY)
            );
        }
    }
}
