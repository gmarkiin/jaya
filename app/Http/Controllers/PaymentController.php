<?php

namespace App\Http\Controllers;

use App\DTO\PaymentCreateDTO;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class PaymentController extends BaseController
{
    public function create(Request $request): array
    {
        $paymentCreateDto = new PaymentCreateDTO($request->toArray());
    }
}
