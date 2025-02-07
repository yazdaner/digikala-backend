<?php


use Illuminate\Support\Facades\Route;
use Modules\sellers\App\Http\Controllers\Auth\AuthenticationController;
use Modules\sellers\App\Http\Controllers\Auth\SellerPasswordController;
use Modules\sellers\App\Http\Controllers\Auth\RegisterAddInfoController;
use Modules\sellers\App\Http\Controllers\Auth\CheckVerificationController;
use Modules\sellers\App\Http\Controllers\Auth\RegisterFinalStepController;
use Modules\sellers\App\Http\Controllers\Auth\SendVerificationCodeController;

Route::prefix('seller')->middleware('guest')->group(function(){
    Route::post('sign-in',[AuthenticationController::class,'signIn']);
    Route::post('login',[AuthenticationController::class,'login']);
    Route::post('logout',[AuthenticationController::class,'logout']);
    Route::post('send/verify-code',SendVerificationCodeController::class);
    Route::post('active-code/verify',CheckVerificationController::class);
    Route::post('account/set-password',SellerPasswordController::class);
    Route::post('account/add-info',RegisterAddInfoController::class);
    Route::post('account/final-step',RegisterFinalStepController::class);
});
