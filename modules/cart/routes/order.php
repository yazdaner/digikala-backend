<?php

use Illuminate\Support\Facades\Route;
use Modules\cart\App\Http\Controllers\Order\Admin\FactorsController;
use Modules\cart\App\Http\Controllers\Order\Admin\LabelInfoController;
use Modules\cart\App\Http\Controllers\Order\Admin\OrderInfoController;
use Modules\cart\App\Http\Controllers\Order\Admin\OrderListController;
use Modules\cart\App\Http\Controllers\Order\User\UserOrdersController;
use Modules\cart\App\Http\Controllers\Order\Admin\CompanyInfoController;
use Modules\cart\App\Http\Controllers\Order\User\UserOrderInfoController;
use Modules\cart\App\Http\Controllers\Order\Admin\SubmissionInfoController;
use Modules\cart\App\Http\Controllers\Order\Admin\SubmissionListController;
use Modules\cart\App\Http\Controllers\Order\User\CheckOrderPaymentController;
use Modules\cart\App\Http\Controllers\Order\User\UserOrderStatisticsController;
use Modules\cart\App\Http\Controllers\Order\Admin\SubmissionsStatisticsController;
use Modules\cart\App\Http\Controllers\Order\Admin\ChangeSubmissionStatusController;

Route::prefix('admin')->middleware(AdminMiddleware)->group(function () {

    Route::get('/orders',OrderListController::class);
    Route::delete('/orders/{id}',[OrderListController::class,'destroy']);
    Route::post('/orders/{id}/restore',[OrderListController::class,'restore']);
    Route::get('/order/{id}/info',OrderInfoController::class);
   
    Route::get('/submissions',SubmissionListController::class);
    Route::get('/submissions/statistics',SubmissionsStatisticsController::class);
    Route::post('/submission/{submission}/change-status',ChangeSubmissionStatusController::class);
    Route::get('/submission/{id}/info',SubmissionInfoController::class);
    
    Route::post('/order/setting/company',CompanyInfoController::class);
    Route::get('/orders/label-info',LabelInfoController::class);
    Route::get('/orders/factors',FactorsController::class);
});

Route::prefix('user')->middleware(['auth:sanctum'])->group(function () {
    Route::get('order/check-payment', CheckOrderPaymentController::class);
    
    Route::get('orders/statistics', UserOrderStatisticsController::class);
    Route::get('orders', UserOrdersController::class);
    Route::get('order/{id}/info', UserOrderInfoController::class);
});

Route::get('/order/setting/company',CompanyInfoController::class);
