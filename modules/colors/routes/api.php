<?php

use Illuminate\Support\Facades\Route;
use Modules\colors\App\Http\Controllers\ColorController;

Route::prefix('admin')->middleware([])->group(function(){

    Route::resource('colors',ColorController::class)
    ->except(['create','edit']);

    Route::post('colors/{id}/restore',[ColorController::class,'restore']);

});



