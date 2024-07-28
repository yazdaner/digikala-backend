<?php

use Illuminate\Support\Facades\Route;
use Modules\sizes\App\Http\Controllers\SizeController;

Route::prefix('admin')->middleware(AdminMiddleware)->group(function(){

    Route::resource('sizes',SizeController::class)
    ->except(['create','edit']);

    Route::post('sizes/{id}/restore',[SizeController::class,'restore']);

});



