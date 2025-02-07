<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\sellers\App\Http\Controllers\Auth\AuthenticationController;

require __DIR__ . '/guest.php';
require __DIR__ . '/products.php';
require __DIR__ . '/profile.php';



Route::middleware('auth.seller:sanctum')->prefix('seller')->group(function () {
    Route::get('/', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout',[AuthenticationController::class,'logout']);
});
