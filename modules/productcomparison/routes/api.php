<?php

use Illuminate\Support\Facades\Route;
use Modules\productcomparison\App\Http\Controllers\CompareProductsController;

Route::get('product/compare', CompareProductsController::class);
