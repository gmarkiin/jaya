<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class PaymentCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'transaction_amount' => 'required',
            'installments' => 'required',
            'token' => 'required',
            'payment_method_id' => 'required',
            'payer.email' => 'required',
            'payer.identification.type' => 'required',
            'payer.identification.number' => 'required'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $message = 'Payment not provided in the request body';

        throw new HttpResponseException(
            response()->json([
                'message' => $message,
            ], Response::HTTP_BAD_REQUEST)
        );
    }
}
