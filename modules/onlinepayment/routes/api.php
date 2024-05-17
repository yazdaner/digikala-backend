<?php

use Illuminate\Support\Facades\Route;
use Modules\onlinepayment\App\Http\Controllers\PaymentController;

Route::prefix('admin')->middleware(AdminMiddleware)->group(function(){
    Route::get('payments',PaymentController::class);
    Route::delete('payments/{id}',[PaymentController::class,'destroy']);
    Route::post('payments/{id}/restore',[PaymentController::class,'restore']);
});
