<?php

use Illuminate\Support\Facades\Route;
use Modules\users\App\Http\Controllers\UserSettingController;
use Modules\users\App\Http\Controllers\Profile\UpdatePasswordController;

Route::prefix('admin')->middleware(AdminMiddleware)->group(function(){

    Route::match(['get', 'post'],'setting/users',UserSettingController::class);

});

Route::prefix('user')->middleware(['auth:sanctum'])->group(function(){

    Route::post('/profile/update-password',UpdatePasswordController::class);

});

require base_path('modules/users/routes/guest.php');

