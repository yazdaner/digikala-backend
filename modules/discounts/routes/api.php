<?php

use Illuminate\Support\Facades\Route;
use Modules\discounts\App\Http\Controllers\DiscountController;
use Modules\discounts\App\Http\Controllers\CheckDiscountCodeController;

Route::prefix('admin')->middleware(AdminMiddleware)->group(function () {
    Route::resource('discounts', DiscountController::class)
        ->except(['create', 'edit']);
    Route::post('discounts/{id}/restore', [DiscountController::class, 'restore']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::post('discount/check', CheckDiscountCodeController::class);
});
