<?php

use Illuminate\Support\Facades\Route;
use Modules\categories\App\Http\Controllers\CategoryController;
use Modules\categories\App\Http\Controllers\SpecificationController;
use Modules\categories\App\Http\Controllers\ProductSpecificationController;

Route::prefix('admin')->middleware(AdminMiddleware)->group(function(){

    Route::resource('categories',CategoryController::class)
    ->except(['create','edit']);

    Route::post('categories/{id}/restore',[CategoryController::class,'restore']);

    // specifications

    Route::post('categories/{id}/specifications',[SpecificationController::class,'store']);
    Route::delete('categories/specifications/{id}',[SpecificationController::class,'destroy']);
});

Route::get('categories/all',[CategoryController::class,'all']);
Route::get('categories/{id}/specifications',[SpecificationController::class,'index']);
Route::get('product/{id}/specifications',ProductSpecificationController::class);
