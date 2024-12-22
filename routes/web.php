<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? 'true' : 'false';
});

Route::get('/logout', function () {
    return auth()->logout();
});

Route::get('/ad', function () {
    return Hash::make('admin');
});
