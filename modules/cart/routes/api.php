<?php

use Illuminate\Support\Facades\Route;
use Modules\cart\App\Http\Controllers\Cart\AddProductToCartController;
use Modules\cart\App\Http\Controllers\Cart\EmptyCartController;
use Modules\cart\App\Http\Controllers\Cart\MoveProductsController;
use Modules\cart\App\Http\Controllers\Cart\ReturnSubmissionsController;
use Modules\cart\App\Http\Controllers\Cart\SaveCartToDatabaseController;
use Modules\cart\App\Http\Controllers\Cart\AddProductToNextCartController;
use Modules\cart\App\Http\Controllers\Cart\RemoveProductFromCartController;
use Modules\cart\App\Http\Controllers\Cart\AddProductToCurrentCartController;
use Modules\cart\App\Http\Controllers\Cart\ReturnCartInfoController;

Route::post('cart/add-product',AddProductToCartController::class);
Route::post('cart/remove-product',RemoveProductFromCartController::class);
Route::post('cart',ReturnCartInfoController::class);


Route::prefix('cart')->middleware(['auth:sanctum'])->group(function(){
    Route::post('add-next-card',AddProductToNextCartController::class);
    Route::post('add-current-card',AddProductToCurrentCartController::class);
    Route::get('empty',EmptyCartController::class);
    Route::post('move-products',MoveProductsController::class);
});

Route::prefix('user')->middleware(['auth:sanctum'])->group(function(){
    Route::post('card/save-database',SaveCartToDatabaseController::class);
    Route::get('card/submissions',ReturnSubmissionsController::class);
    Route::post('card/save-database',SaveCartToDatabaseController::class);
});

require __DIR__.'/order.php';
