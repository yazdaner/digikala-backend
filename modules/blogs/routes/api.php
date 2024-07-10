<?php

use Illuminate\Support\Facades\Route;
use Modules\blogs\App\Http\Controllers\BlogTagController;
use Modules\blogs\App\Http\Controllers\BlogPostController;
use Modules\blogs\App\Http\Controllers\BlogCategoryController;
use Modules\blogs\App\Http\Controllers\SearchBlogPostsController;

Route::prefix('admin')->middleware(AdminMiddleware)->group(function(){
    Route::resource('blog/categories',BlogCategoryController::class)->except(['create','edit']);
    Route::post('blog/categories/{id}/restore',[BlogCategoryController::class,'restore']);
    
    Route::resource('blog/tags',BlogTagController::class)->except(['create','edit']);
    Route::post('blog/tags/{id}/restore',[BlogTagController::class,'restore']);
   
    Route::resource('blog/posts',BlogPostController::class)->except(['create','edit']);
    Route::post('blog/posts/{id}/restore',[BlogPostController::class,'restore']);
   
});

Route::get('blog/categories/all',[BlogCategoryController::class,'all']);
Route::get('blog/tags/all',[BlogTagController::class,'all']);
Route::get('blog/posts',SearchBlogPostsController::class);
