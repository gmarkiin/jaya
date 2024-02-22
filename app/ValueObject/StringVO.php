<?php

namespace App\ValueObject;

use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class StringVO
{
    public readonly mixed $value;

    public function __construct(mixed $value)
    {
        $this->validateValue($value);
        $this->value = $value;
    }

    private function validateValue(mixed $value): void
    {
        if (!is_string($value)) {
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
