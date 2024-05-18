<?php

use Illuminate\Support\Facades\Route;
use Modules\cart\App\Http\Controllers\Order\VerifyOrderController;

Route::match(['get','post'],'order/verify', VerifyOrderController::class);
