<?php

use Illuminate\Support\Facades\Route;
use Modules\cart\App\Http\Controllers\Order\CheckOrderPaymentController;
Route::prefix('user')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/order/check-payment', CheckOrderPaymentController::class);
});
