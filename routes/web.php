<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? 'true' : 'false';
});

Route::get('/logout', function () {
    return auth()->logout();
});
