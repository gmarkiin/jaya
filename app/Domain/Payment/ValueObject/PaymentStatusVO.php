<?php

namespace App\Domain\Payment\ValueObject;

use App\Enum\PaymentStatusEnum;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class PaymentStatusVO
{
    public readonly mixed $status;

    public function __construct(mixed $status)
    {
        $this->validateStatus($status);
        $this->status = $status;
    }

    private function validateStatus(mixed $status): void
    {
        if (!in_array($status, PaymentStatusEnum::availableStatus())) {
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Invalid payment status',
                ], Response::HTTP_INTERNAL_SERVER_ERROR)
            );
        }
    }
}
