<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {

        });
    }

    public function render($request, Throwable $e): Response|JsonResponse
    {
        $message = 'Invalid payment provided.The possible reasons are:' .
            'A field of the provided payment was null or with invalid values';

        switch ($e) {
            case $e instanceof InvalidPropertyValueException:
                return response()->json(['message' => $message], $e->getCode());
            case $e instanceof BankslipNotFoundException:
            case $e instanceof PaymentNotFoundException:
            case $e instanceof InvalidRequestPayload:
                return response()->json(['message' => $e->getMessage()], $e->getCode());
            default: return parent::render($request, $e);
        }
    }
}
