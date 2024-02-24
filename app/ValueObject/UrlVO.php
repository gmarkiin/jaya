<?php

namespace App\ValueObject;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Exceptions\HttpResponseException;

class UrlVO
{
    public function __construct(public readonly mixed $value)
    {
        $this->validateValue();
    }

    private function validateValue(): void
    {
        $pattern = '/^(https?):\/\/([^\s\/?.#]+\.?)+(\/\S*)?$/i';
        if (!is_string($this->value) || !preg_match($pattern, $this->value)) {
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
