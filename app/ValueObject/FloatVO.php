<?php

namespace App\ValueObject;

use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class FloatVO
{
    public function __construct(public readonly mixed $value)
    {
        $this->validateAmount();
    }

    private function validateAmount(): void
    {
        if (!is_float($this->value) || $this->value <= 0) {
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
