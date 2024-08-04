<?php


use Illuminate\Support\Facades\Route;
use Modules\sellers\App\Http\Controllers\Profile\Address\ListController;
use Modules\sellers\App\Http\Controllers\Profile\Address\StoreController;
use Modules\sellers\App\Http\Controllers\Profile\Address\RemoveController;
use Modules\sellers\App\Http\Controllers\Profile\Address\UpdateController;

Route::middleware(['auth.seller:sanctum'])->prefix('seller')->group(function () {
    Route::get('profile/addresses', ListController::class);
    Route::delete('profile/address/{id}', RemoveController::class);
    Route::delete('profile/address/create', StoreController::class);
    Route::put('profile/address/{id}', UpdateController::class);
});
