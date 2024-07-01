<?php

use Illuminate\Support\Facades\Route;
use Modules\cart\App\Http\Controllers\Order\Admin\OrderListController;
use Modules\cart\App\Http\Controllers\Order\CheckOrderPaymentController;

Route::prefix('admin')->middleware(AdminMiddleware)->group(function () {

    Route::get('/orders',OrderListController::class);
    Route::delete('/orders/{id}',[OrderListController::class,'destroy']);
    Route::post('/orders/{id}/restore',[OrderListController::class,'restore']);

});


Route::prefix('user')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/order/check-payment', CheckOrderPaymentController::class);
});
