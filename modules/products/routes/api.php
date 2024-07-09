<?php

use Illuminate\Support\Facades\Route;
use Modules\products\App\Http\Controllers\ShopController;
use Modules\products\App\Http\Controllers\ProductController;

Route::prefix('admin')->middleware(AdminMiddleware)->group(function(){

    Route::resource('products',ProductController::class)
    ->except(['create','edit']);

    Route::post('products/{id}/restore',[ProductController::class,'restore']);
});

Route::get('product/yzd-{id}/{slug}',[ShopController::class,'product']);
Route::get('product/{id}/categories',[ShopController::class,'productCategories']);