<?php

use Illuminate\Support\Facades\Route;
use Modules\shop\App\Http\Controllers\ShopController;
use Modules\shop\App\Http\Controllers\BestSellingController;

Route::get('shop/products',[ShopController::class,'products']);
Route::get('shop/best-selling',BestSellingController::class);
Route::get('shop/categories-data',[ShopController::class,'categoriesData']);
