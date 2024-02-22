<?php

namespace App\ValueObject;

use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class FloatVO
{
    public readonly mixed $amount;

    public function __construct(mixed $amount)
    {
        $this->validateAmount($amount);
        $this->amount = $amount;
    }

    private function validateAmount(mixed $amount): void
    {
        if (!is_float($amount) || $amount <= 0) {
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
