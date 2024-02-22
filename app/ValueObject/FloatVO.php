<?php

namespace App\ValueObject;

use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class FloatVO
{
    public readonly mixed $value;

    public function __construct(mixed $value)
    {
        $this->validateAmount($value);
        $this->value = $value;
    }

    private function validateAmount(mixed $value): void
    {
        if (!is_float($value) || $value <= 0) {
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
