<?php

use Illuminate\Support\Facades\Route;
use Modules\pages\App\Http\Controllers\PageController;

Route::prefix('admin')->middleware(AdminMiddleware)->group(function () {

    Route::resource('pages', PageController::class)
        ->except(['create', 'edit']);

    Route::post('pages/{id}/restore', [PageController::class, 'restore']);
});

Route::get('pages/{slug}', [PageController::class, 'find']);
