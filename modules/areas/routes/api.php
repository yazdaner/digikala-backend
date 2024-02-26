<?php

use Illuminate\Support\Facades\Route;
use Modules\areas\App\Http\Controllers\CityController;
use Modules\areas\App\Http\Controllers\ProvinceController;

Route::prefix('admin')->middleware(AdminMiddleware)->group(function () {
    Route::resource('provinces', ProvinceController::class)
        ->except(['create', 'edit']);

    Route::post('provinces/{id}/restore', [ProvinceController::class, 'restore']);

    Route::resource('cities', CityController::class)
        ->except(['create', 'edit']);

    Route::post('cities/{id}/restore', [CityController::class, 'restore']);
});

Route::get('cities/all',[CityController::class,'all']);
Route::get('provinces/all',[ProvinceController::class,'all']);
Route::get('provinces/{id}/cities',[CityController::class,'ProvinceCities']);
