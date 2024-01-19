<?php

use Illuminate\Support\Facades\Route;
use Modules\sliders\App\Http\Controllers\SliderController;

Route::prefix('admin')->middleware(AdminMiddleware)->group(function(){

    Route::resource('sliders',SliderController::class)
    ->except(['create','edit']);

    Route::post('sliders/{id}/restore',[SliderController::class,'restore']);

});
