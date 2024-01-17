<?php

use Illuminate\Support\Facades\Route;
use Modules\categories\App\Http\Controllers\CategoryController;

Route::prefix('admin')->middleware(AdminMiddleware)->group(function(){

    Route::resource('categories',CategoryController::class)
    ->except(['create','edit']);

    Route::post('categories/{id}/restore',[CategoryController::class,'restore']);

});

Route::get('categories/list',[CategoryController::class,'all']);
