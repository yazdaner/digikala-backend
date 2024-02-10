<?php

use Illuminate\Support\Facades\Route;
use Modules\holidays\App\Http\Controllers\HolidayController;

Route::prefix('admin')->middleware(AdminMiddleware)->group(function () {
    Route::get('setting/holiday', [HolidayController::class, 'index']);
    Route::post('setting/holiday', [HolidayController::class, 'store']);
});
