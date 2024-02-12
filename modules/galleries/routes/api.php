<?php

use Illuminate\Support\Facades\Route;
use Modules\galleries\App\Http\Controllers\GallerySettingController;

Route::prefix('admin')->middleware(AdminMiddleware)->group(function(){

    Route::match(['get', 'post'],'setting/gallery',GallerySettingController::class);

});

