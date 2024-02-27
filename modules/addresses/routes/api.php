<?php

use Illuminate\Support\Facades\Route;
use Modules\addresses\App\Http\Controllers\GetAddresses;
use Modules\addresses\App\Http\Controllers\CreateAddress;
use Modules\addresses\App\Http\Controllers\DeleteAddress;
use Modules\addresses\App\Http\Controllers\UpdateAddress;

Route::prefix('user')->middleware(['auth:sanctum'])->group(function () {

    Route::get('addresses', GetAddresses::class);
    Route::post('address/create', CreateAddress::class);
    Route::delete('address/{id}/delete', DeleteAddress::class);
    Route::put('address/{id}/update', UpdateAddress::class);

});
