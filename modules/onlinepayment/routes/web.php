<?php

use Illuminate\Support\Facades\Route;
use Modules\onlinepayment\App\Http\Controllers\GatewayConnectController;

Route::get('shop/gateway-connect',GatewayConnectController::class);
