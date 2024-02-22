<?php

namespace App\Domain\Payment\ValueObject;

use App\Enum\PaymentStatusEnum;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class PaymentStatusVO
{
    public function __construct(public readonly mixed $value)
    {
        $this->validateStatus();
    }

    private function validateStatus(): void
    {
        if (!in_array($this->value, PaymentStatusEnum::availableStatus())) {
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Invalid payment status',
                ], Response::HTTP_INTERNAL_SERVER_ERROR)
            );
        }
    }
}
