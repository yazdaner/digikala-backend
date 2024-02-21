<?php

use Illuminate\Support\Facades\Route;
use Modules\products\App\Models\Product;
use Modules\variations\App\Models\Variation;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    dd(runEvent('product:info',48,true));
});

