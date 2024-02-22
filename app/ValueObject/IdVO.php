<?php

namespace App\ValueObject;

use Illuminate\Http\Exceptions\HttpResponseException;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

class IdVO
{
    public function __construct(public readonly mixed $value)
    {
        $this->validateValue();
    }

    private function validateValue(): void
    {
        if (!Uuid::isValid($this->value)) {
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Invalid uuid',
                ], Response::HTTP_INTERNAL_SERVER_ERROR)
            );
        }
    }
}
