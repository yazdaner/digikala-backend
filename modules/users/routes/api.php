<?php

use Illuminate\Support\Facades\Route;
use Modules\users\App\Http\Controllers\UserSettingController;

Route::prefix('admin')->middleware(AdminMiddleware)->group(function(){

    Route::match(['get', 'post'],'setting/users',UserSettingController::class);

});
