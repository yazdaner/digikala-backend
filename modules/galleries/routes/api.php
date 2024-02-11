<?php

use Illuminate\Support\Facades\Route;
use Modules\galleries\App\Http\Controllers\SettingController;

Route::prefix('admin')->middleware(AdminMiddleware)->group(function(){


    Route::match(['get', 'post'],'setting/gallery',SettingController::class);

});

