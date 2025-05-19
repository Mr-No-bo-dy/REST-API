<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArticleController;
//use App\Http\Controllers\Api\CategoryController;

Route::prefix('v1')->group(function () {
    // Articles
    Route::apiResource('articles', ArticleController::class);

//    // Categories
//    Route::get('categories', [CategoryController::class, 'index']);
//    Route::get('categories/{id}', [CategoryController::class, 'show']);
});
