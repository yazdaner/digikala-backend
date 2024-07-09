<?php

use Illuminate\Support\Facades\Route;
use Modules\shop\App\Http\Controllers\ShopController;

Route::get('shop/products',[ShopController::class,'products']);