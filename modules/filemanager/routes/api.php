<?php

use Illuminate\Support\Facades\Route;
use Modules\filemanager\App\Http\Controllers\RemoveFileController;
use Modules\filemanager\App\Http\Controllers\UploadFileController;
use Modules\filemanager\App\Http\Controllers\FileManagerController;
use Modules\filemanager\App\Http\Controllers\CreateFolderController;
use Modules\filemanager\App\Http\Controllers\UploadSliceFileController;

Route::prefix('admin/filemanager')->middleware(AdminMiddleware)->group(function () {
    Route::get('/', FileManagerController::class);
    Route::post('upload', UploadFileController::class);
    Route::post('upload-slice', UploadSliceFileController::class);
    Route::post('remove', RemoveFileController::class);
    Route::post('create-folder', CreateFolderController::class);
});