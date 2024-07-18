<?php


use Illuminate\Support\Facades\Route;
use Modules\sellers\App\Http\Controllers\Product\AllProductController;
use Modules\sellers\App\Http\Controllers\Product\VariationsGeneralInfoController;

Route::middleware(['auth.seller:sanctum'])->prefix('seller')->group(function(){
    Route::post('/variation/general-info',VariationsGeneralInfoController::class);
    Route::post('/all/products',AllProductController::class);
});