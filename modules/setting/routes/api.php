<?php

use Illuminate\Support\Facades\Route;
use Modules\setting\App\Http\Controllers\ShopController;
use Modules\setting\App\Http\Controllers\AdminShopController;
use Modules\setting\App\Http\Controllers\WebServiceController;

Route::prefix('admin')->middleware(AdminMiddleware)->group(function(){
    Route::get('setting/web-services', [WebServiceController::class, 'getValue']);
    Route::post('setting/web-services', [WebServiceController::class, 'setValue']);
    Route::post('setting/shop', AdminShopController::class);
});
Route::get('setting/shop', ShopController::class);