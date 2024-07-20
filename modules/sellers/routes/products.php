<?php


use Illuminate\Support\Facades\Route;
use Modules\sellers\App\Http\Controllers\Product\AllProductController;
use Modules\sellers\App\Http\Controllers\Product\SellerProductsController;
use Modules\sellers\App\Http\Controllers\Product\ProductGeneralInfoController;
use Modules\sellers\App\Http\Controllers\Product\VariationsGeneralInfoController;

Route::middleware(['auth.seller:sanctum'])->prefix('seller')->group(function(){
    Route::get('variation/general-info',VariationsGeneralInfoController::class);
    //seller shop
    Route::get('products/all',AllProductController::class);
    //seller product
    Route::get('products',SellerProductsController::class);
    Route::get('products/general-info',ProductGeneralInfoController::class);
});