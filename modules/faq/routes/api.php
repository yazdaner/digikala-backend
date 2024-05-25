<?php

use Illuminate\Support\Facades\Route;
use Modules\faq\App\Http\Controllers\FaqScoreController;
use Modules\faq\App\Http\Controllers\FaqCategoryController;
use Modules\faq\App\Http\Controllers\FaqQuestionController;
use Modules\faq\App\Http\Controllers\FaqQuestionInfoController;
use Modules\faq\App\Http\Controllers\ReturnFaqQuestionController;

Route::prefix('admin')->middleware(AdminMiddleware)->group(function () {
    Route::resource('faq/categories', FaqCategoryController::class)->except(['create', 'edit']);
    Route::post('faq/categories/{id}/restore', [FaqCategoryController::class, 'restore']);

    Route::resource('faq/questions', FaqQuestionController::class)->except(['create', 'edit']);
    Route::post('faq/questions/{id}/restore', [FaqQuestionController::class, 'restore']);
});

Route::prefix('user')->middleware(['auth:sanctum'])->group(function () {
    Route::post('faq/{faq_id}/score', FaqScoreController::class);
});

Route::get('faq/category/all', [FaqCategoryController::class,'all']);
Route::get('faq/category/{id}', [FaqCategoryController::class,'show']);
Route::get('faq/questions', ReturnFaqQuestionController::class);
Route::get('faq/question/{id}/info', FaqQuestionInfoController::class);

