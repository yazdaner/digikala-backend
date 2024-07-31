<?php

use Illuminate\Support\Facades\Route;
use Modules\promotions\App\Http\Controllers\PromotionController;
use Modules\promotions\App\Http\Controllers\ProductsListController;
use Modules\promotions\App\Http\Controllers\BestProductsOfferController;
use Modules\promotions\App\Http\Controllers\AddProductsPromotionController;

Route::prefix('admin')->middleware(AdminMiddleware)->group(function () {
    Route::get('promotions/products-list', ProductsListController::class);
    Route::resource('promotions', PromotionController::class)
        ->except(['create', 'edit']);
    Route::post('promotions/{id}/restore', [PromotionController::class, 'restore']);
    Route::get('promotions/{id}/info', [PromotionController::class, 'info']);

    Route::post('promotion/add-products', AddProductsPromotionController::class);
});

Route::get('promotion/best-products', BestProductsOfferController::class);