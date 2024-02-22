<?php

namespace App\Domain\Payment\ValueObject;

use App\Enum\PaymentStatusEnum;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class PaymentStatusVO
{
    public readonly mixed $value;

    public function __construct(mixed $value)
    {
        $this->validateStatus($value);
        $this->value = $value;
    }

    private function validateStatus(mixed $value): void
    {
        if (!in_array($value, PaymentStatusEnum::availableStatus())) {
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Invalid payment status',
                ], Response::HTTP_INTERNAL_SERVER_ERROR)
            );
        }
    }
}
