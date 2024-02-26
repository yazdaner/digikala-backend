<?php

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use Modules\normaldelivery\import\UsersImport;
use Modules\normaldelivery\import\ShippingIntervalsImport;

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
    Excel::import(new ShippingIntervalsImport(1), storage_path('/app/excel/1.xlsx'));
});
