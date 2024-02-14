<?php

use Illuminate\Support\Facades\Route;
use Modules\users\App\Http\Controllers\Auth\SetPasswordController;
use Modules\users\App\Http\Controllers\Auth\SendVerifyCodeController;
use Modules\users\App\Http\Controllers\Auth\CheckHasAccountController;
use Modules\users\App\Http\Controllers\Auth\CheckVerifyCodeController;
use Modules\users\App\Http\Controllers\Auth\ResendOneTimePasswordController;
use Modules\users\App\Http\Controllers\Auth\ReturnRegisterSettingController;

Route::middleware('guest')->group(function(){

    Route::post('user/check-has-account',CheckHasAccountController::class);
    Route::get('setting/register',ReturnRegisterSettingController::class);

    Route::post('user/send/verify-code',SendVerifyCodeController::class);
    Route::post('user/check/verify-code',CheckVerifyCodeController::class);
    Route::post('user/resend/one-time-password',ResendOneTimePasswordController::class);
    Route::post('user/account/set-password',SetPasswordController::class);
    // Route::post('user/reset-password',CheckHasAccountController::class);

});
