<?php

use Illuminate\Support\Facades\Route;
use Modules\discounts\App\Http\Controllers\DiscountController;

Route::prefix('admin')->middleware(AdminMiddleware)->group(function(){
    Route::resource('discounts',DiscountController::class)
    ->except(['discounts','edit']);
    Route::post('brands/{id}/restore',[DiscountController::class,'restore']);
});

