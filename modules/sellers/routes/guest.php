<?php


use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Modules\sellers\App\Http\Controllers\Auth\AuthenticationContoller;
use Modules\sellers\App\Http\Controllers\Auth\SellerPasswordContoller;
use Modules\sellers\App\Http\Controllers\Auth\RegisterAddInfoContoller;
use Modules\sellers\App\Http\Controllers\Auth\CheckVerificationContoller;
use Modules\sellers\App\Http\Controllers\Auth\RegisterFinalStepContoller;
use Modules\sellers\App\Http\Controllers\Auth\SendVerificationCodeContoller;

Route::prefix('seller')->middleware('guest')->group(function(){
    Route::post('sign-in',[AuthenticationContoller::class,'signIn']);
    Route::post('login',[AuthenticationContoller::class,'login']);
    Route::post('logout',[AuthenticationContoller::class,'logout']);
    Route::post('send/verify-code',SendVerificationCodeContoller::class);
    Route::post('active-code/verify',CheckVerificationContoller::class);
    Route::post('account/set-password',SellerPasswordContoller::class);
    Route::post('account/add-info',RegisterAddInfoContoller::class);
    Route::post('account/final-step',RegisterFinalStepContoller::class);
    Route::post('reset-password',[NewPasswordController::class,'store']);
});