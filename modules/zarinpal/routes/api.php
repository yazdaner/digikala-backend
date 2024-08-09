<?php
use Illuminate\Support\Facades\Route;
use Modules\zarinpal\App\Http\Controllers\GatewayController;
Route::prefix('admin')->middleware(AdminMiddleware)->group(function(){
    Route::match(['get','post'],'setting/gateway/zarinpal',GatewayController::class);
});
