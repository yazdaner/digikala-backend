<?php

use Illuminate\Support\Facades\Route;
use Modules\brands\App\Http\Controllers\BrandController;

Route::prefix('admin')->middleware([])->group(function(){

    Route::resource('brands',BrandController::class)
    ->except(['create','edit']);

});



