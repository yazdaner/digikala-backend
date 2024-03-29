<?php

use Illuminate\Support\Facades\Route;
use Modules\brands\App\Http\Controllers\BrandController;

Route::prefix('admin')->middleware(AdminMiddleware)->group(function(){

    Route::resource('brands',BrandController::class)
    ->except(['create','edit']);

    Route::post('brands/{id}/restore',[BrandController::class,'restore']);

});

Route::get('brands/all',[BrandController::class,'all']);

