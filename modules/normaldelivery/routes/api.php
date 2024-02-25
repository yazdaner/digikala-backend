<?php

use Illuminate\Support\Facades\Route;
use Modules\normaldelivery\App\Http\Controllers\NormalPostingSetting;
use Modules\normaldelivery\App\Http\Controllers\SaveNormalPostingSetting;
use Modules\normaldelivery\App\Http\Controllers\ExportDeliveryTimeIntervals;
use Modules\normaldelivery\App\Http\Controllers\ImportDeliveryTimeIntervals;

Route::prefix('admin')->middleware(AdminMiddleware)->group(function () {

    Route::get('setting/normal-delivery', NormalPostingSetting::class);
    Route::post('setting/normal-delivery', SaveNormalPostingSetting::class);


    Route::post('setting/normal-delivery/import-time', ImportDeliveryTimeIntervals::class);
    Route::post('setting/normal-delivery/export-time', ExportDeliveryTimeIntervals::class);

});
