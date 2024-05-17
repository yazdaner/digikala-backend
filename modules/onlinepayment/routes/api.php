<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(AdminMiddleware)->group(function(){

    // Route::post('products/{id}/restore',[ProductController::class,'restore']);

});
