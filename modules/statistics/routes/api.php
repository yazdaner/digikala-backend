<?php

use Illuminate\Support\Facades\Route;
use Modules\statistics\App\Http\Controllers\ProductSaleController;
use Modules\statistics\App\Http\Controllers\MostPopularBrandsController;
use Modules\statistics\App\Http\Controllers\ProvinceStatisticsController;
use Modules\statistics\App\Http\Controllers\GeneralSaleStatisticsController;
use Modules\statistics\App\Http\Controllers\StatisticsSellByCategoryBrandController;

Route::prefix('admin')->middleware(AdminMiddleware)->group(function(){
    Route::get('statistics/sale-province',ProvinceStatisticsController::class);
    Route::get('statistics/general-province',GeneralSaleStatisticsController::class);
    Route::get('statistics/product-sale',ProductSaleController::class);
    Route::get('statistics/sell/by-category-brand',StatisticsSellByCategoryBrandController::class);
});
Route::get('shop/most-popular/brands',MostPopularBrandsController::class);
