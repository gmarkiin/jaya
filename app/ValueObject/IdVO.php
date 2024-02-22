<?php

namespace App\ValueObject;

use Illuminate\Http\Exceptions\HttpResponseException;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

class IdVO
{
    public readonly mixed $value;

    public function __construct(mixed $value)
    {
        $this->validateValue($value);
        $this->value = $value;
    }

    private function validateValue(mixed $value): void
    {
        if (!Uuid::isValid($value)) {
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Invalid uuid',
                ], Response::HTTP_INTERNAL_SERVER_ERROR)
            );
        }
    }
}
