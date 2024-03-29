<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::prefix('/rest')->controller(PaymentController::class)->group(function () {
    Route::post('/payments', 'createPayment');
    Route::get('/payments', 'listAllPayments');
    Route::get('/payments/{id}', 'listPayment');
    Route::patch('/payments/{id}', 'confirmPayment');
    Route::delete('/payments/{id}', 'cancelPayment');
});

Route::get('/api-docs', function () {
    return Response::file(public_path('/api-documentation/swagger.json'));
});
