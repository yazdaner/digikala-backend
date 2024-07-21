<?php

use Illuminate\Support\Facades\Route;
use Modules\filemanager\App\Http\Controllers\RemoveFileController;
use Modules\filemanager\App\Http\Controllers\UploadFileController;
use Modules\filemanager\App\Http\Controllers\FileManagerController;
use Modules\filemanager\App\Http\Controllers\CreateFolderController;
use Modules\filemanager\App\Http\Controllers\UploadSliceFileController;

Route::prefix('admin')->middleware(AdminMiddleware)->group(function () {
    Route::get('filemanager', FileManagerController::class);
    Route::post('filemanager/upload', UploadFileController::class);
    Route::post('filemanager/upload-slice', UploadSliceFileController::class);
    Route::post('filemanager/remove', RemoveFileController::class);
    Route::post('filemanager/create-folder', CreateFolderController::class);
});