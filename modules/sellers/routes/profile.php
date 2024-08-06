<?php

use Illuminate\Support\Facades\Route;
use Modules\sellers\App\Http\Controllers\Profile\Address\ListController;
use Modules\sellers\App\Http\Controllers\Profile\Address\StoreController;
use Modules\sellers\App\Http\Controllers\Profile\Address\RemoveController;
use Modules\sellers\App\Http\Controllers\Profile\Address\UpdateController;
use Modules\sellers\App\Http\Controllers\Profile\Information\UpdateNameController;
use Modules\sellers\App\Http\Controllers\Profile\Information\UpdateEmailController;
use Modules\sellers\App\Http\Controllers\Profile\Information\UpdateShopLogoController;
use Modules\sellers\App\Http\Controllers\Profile\Information\UpdateShopAboutController;
use Modules\sellers\App\Http\Controllers\Profile\Information\UpdatePhoneNumberController;
use Modules\sellers\App\Http\Controllers\Profile\Information\UpdateShopWebsiteController;
use Modules\sellers\App\Http\Controllers\Profile\Information\RequestUpdateEmailController;
use Modules\sellers\App\Http\Controllers\Profile\Information\UpdateNationalCodeController;
use Modules\sellers\App\Http\Controllers\Profile\Information\UpdateNotificationMobileController;

Route::middleware(['auth.seller:sanctum'])->prefix('seller/profile')->group(function () {
    Route::get('addresses', ListController::class);
    Route::post('address', StoreController::class);
    Route::put('address/{id}', UpdateController::class);
    Route::delete('address/{id}', RemoveController::class);

    Route::post('update-information/name',UpdateNameController::class);
    Route::post('update-information/national-code',UpdateNationalCodeController::class);
    Route::post('update-information/notification-mobile',UpdateNotificationMobileController::class);
    Route::post('update-information/phone-number',UpdatePhoneNumberController::class);
    Route::post('update-information/shop-about',UpdateShopAboutController::class);
    Route::post('update-information/shop-website',UpdateShopWebsiteController::class);
    Route::post('update-information/shop-logo',UpdateShopLogoController::class);
    Route::post('update-information/email',UpdateEmailController::class);
    Route::post('request-update/email',RequestUpdateEmailController::class);
});
