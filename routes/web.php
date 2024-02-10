<?php

use Modules\core\Lib\Jdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use Modules\categories\App\Models\Category;

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
    //    dd(config('app.modules'));
    //    dd(config('app.events'));
    $jdf = new Jdf;

    dd(Carbon::now()->timestamp,timestamp($jdf->jdate('Y'),$jdf->jdate('n'),$jdf->jdate('j')));

});

