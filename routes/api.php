<?php

use App\Http\Middleware\ApiTokenMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\CategoryController;

Route::prefix('v1')
    ->middleware(ApiTokenMiddleware::class)
    ->group(function () {
    // Articles
    Route::apiResource('articles', ArticleController::class);

    // Categories
    Route::get('categories', [CategoryController::class, 'index'])->name('api.categories.index');
    Route::get('categories/{id}', [CategoryController::class, 'show'])->name('api.categories.show');
});
