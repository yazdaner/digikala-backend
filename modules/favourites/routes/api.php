<?php

use Illuminate\Support\Facades\Route;
use Modules\favourites\App\Http\Controllers\AddFavouriteController;
use Modules\favourites\App\Http\Controllers\UserFavouriteController;
use Modules\favourites\App\Http\Controllers\CheckFavouriteController;
use Modules\favourites\App\Http\Controllers\RemoveFavouriteController;

Route::prefix('user')->middleware(['auth:sanctum'])->group(function () {
    Route::get('product/{id}/favourite/add', AddFavouriteController::class);
    Route::get('product/{id}/favourite/check', CheckFavouriteController::class);
    Route::delete('product/{id}/favourite/remove', RemoveFavouriteController::class);
    Route::get('favourites', UserFavouriteController::class);
});
