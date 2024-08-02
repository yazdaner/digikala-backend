<?php

use Illuminate\Support\Facades\Route;
use Modules\variations\App\Http\Controllers\SalesLockController;
use Modules\variations\App\Http\Controllers\VariationController;
use Modules\variations\App\Http\Controllers\ExportVariationsController;
use Modules\variations\App\Http\Controllers\UpdateVariationsController;
use Modules\variations\App\Http\Controllers\CategoryVariationController;
use Modules\variations\App\Http\Controllers\ReturnLockDescriptionController;
use Modules\variations\App\Http\Controllers\GeneralUpdateVariationsController;

Route::prefix('admin')->middleware(AdminMiddleware)->group(function () {
    Route::get(
        'category/{id}/variation',
        [CategoryVariationController::class, 'index']
    );

    Route::post(
        'category/{id}/variation',
        [CategoryVariationController::class, 'store']
    );

    Route::get(
        'products/{product_id}/variations',
        [VariationController::class, 'index']
    );

    Route::post(
        'products/{product_id}/variations/store',
        [VariationController::class, 'store']
    );

    Route::put(
        'products/variations/{id}/update',
        [VariationController::class, 'update']
    );

    Route::get(
        'products/variations/{id}/show',
        [VariationController::class, 'show']
    );

    Route::delete(
        'products/variations/{id}/destroy',
        [VariationController::class, 'destroy']
    );

    Route::post(
        'products/variations/{id}/restore',
        [VariationController::class, 'restore']
    );

    Route::post('/variations/export',ExportVariationsController::class);
    Route::post('/variations/update',UpdateVariationsController::class);
    Route::post('/variations/general-update',GeneralUpdateVariationsController::class);

    Route::resource('products/locked',SalesLockController::class)->except(['create','edit']);
});
Route::get('product/{product_id}/lock-description',ReturnLockDescriptionController::class);
