<?php


use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Modules\sellers\App\Http\Controllers\Auth\RegisterContoller;
use Modules\sellers\App\Http\Controllers\Auth\AuthenticationContoller;
use Modules\sellers\App\Http\Controllers\Auth\SellerPasswordContoller;
use Modules\sellers\App\Http\Controllers\Auth\SendVerificationCodeContoller;
use Modules\sellers\App\Http\Controllers\Auth\CheckVerificationCodeContoller;

Route::prefix('seller')->middleware('guest')->group(function(){
    Route::post('sign-in',[AuthenticationContoller::class,'signIn']);
    Route::post('login',[AuthenticationContoller::class,'login']);
    Route::post('send/verify-code',SendVerificationCodeContoller::class);
    Route::post('active-code/verify',CheckVerificationCodeContoller::class);
    Route::post('account/set-password',SellerPasswordContoller::class);
    Route::post('account/add-info',[RegisterContoller::class,'addInfo']);
    Route::post('account/final-step',[RegisterContoller::class,'finalStep']);
    Route::post('reset-password',[NewPasswordController::class,'store']);
});