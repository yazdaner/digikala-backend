<?php

use Illuminate\Support\Facades\Route;
use Modules\warranties\App\Http\Controllers\WarrantyController;

Route::prefix('admin')->middleware(AdminMiddleware)->group(function(){

    Route::resource('warranties',WarrantyController::class)
    ->except(['create','edit']);

    Route::post('warranties/{id}/restore',[WarrantyController::class,'restore']);

});
