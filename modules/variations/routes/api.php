<?php

use Illuminate\Support\Facades\Route;
use Modules\variations\App\Http\Controllers\CategoryVariationController;

Route::prefix('admin')->middleware(AdminMiddleware)->group(function () {
    Route::get(
        'category/{id}/variation',
        [CategoryVariationController::class, 'index']
    );
    Route::post(
        'category/{id}/variation',
        [CategoryVariationController::class, 'store']
    );
});
