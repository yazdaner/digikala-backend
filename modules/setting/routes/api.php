<?php

use Illuminate\Support\Facades\Route;
use Modules\setting\App\Http\Controllers\WebServiceController;

Route::prefix('admin')->middleware(AdminMiddleware)->group(function(){
    Route::get('setting/web-services', [WebServiceController::class, 'getValue']);
    Route::post('setting/web-services', [WebServiceController::class, 'setValue']);
});
