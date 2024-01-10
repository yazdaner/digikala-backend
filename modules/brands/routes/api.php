<?php

use Illuminate\Support\Facades\Route;
use Modules\brands\App\Http\Controllers\BrandController;

Route::prefix('admin')->middleware([])->group(function(){

    Route::resource('brands',BrandController::class)
    ->except(['create','edit']);

    Route::post('brands/{id}/restore',[BrandController::class,'restore']);

});

Route::get('brands/list',[BrandController::class,'all']);

