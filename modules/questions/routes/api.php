<?php

use Illuminate\Support\Facades\Route;
use Modules\questions\App\Http\Controllers\QuestionController;
use Modules\questions\App\Http\Controllers\AddQuestionController;
use Modules\questions\App\Http\Controllers\AnswerScoreController;
use Modules\questions\App\Http\Controllers\ProductQuestionController;
use Modules\questions\App\Http\Controllers\ChangeQuestionStatusController;

Route::prefix('admin')->middleware(AdminMiddleware)->group(function () {
    Route::get('questions', QuestionController::class);
    Route::delete('questions/{question}', [QuestionController::class, 'destroy']);
    Route::post('questions/{question}/change-status', ChangeQuestionStatusController::class);
});

Route::prefix('user')->middleware(['auth:sanctum'])->group(function () {
    Route::post('question', AddQuestionController::class);
    Route::post('asnwer/{asnwer_id}/score', AnswerScoreController::class);
});

Route::get('products/{product}/questions', ProductQuestionController::class);
