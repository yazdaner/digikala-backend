<?php

use Illuminate\Support\Facades\Route;
use Modules\expertreview\App\Http\Controllers\ExpertReviewController;

Route::prefix('admin')->middleware(AdminMiddleware)->group(function () {

    Route::get(
        'products/{product_id}/expert-review',
        [ExpertReviewController::class, 'index']
    );

    Route::post(
        'products/{product_id}/expert-review/store',
        [ExpertReviewController::class, 'store']
    );

    Route::put(
        'products/expert-review/{id}/update',
        [ExpertReviewController::class, 'update']
    );

    Route::get(
        'products/expert-review/{id}/show',
        [ExpertReviewController::class, 'show']
    );

    Route::delete(
        'products/expert-review/{id}/destroy',
        [ExpertReviewController::class, 'destroy']
    );

    Route::post(
        'products/expert-review/{id}/restore',
        [ExpertReviewController::class, 'restore']
    );
});

Route::get('products/{product_id}/expert-review/all',[ExpertReviewController::class,'all']);
