<?php

use Illuminate\Support\Facades\Route;

Route::domain(config('domain.api'))
    ->prefix('v1')
    ->middleware([
        \App\Http\Middleware\RequiresJson::class,
    ])
    ->name('api.v1.')
    ->group(function () {
        Route::post('auth/login', [\App\Http\Controllers\Api\V1\AuthController::class, 'login']);
        Route::post('auth/logout', [\App\Http\Controllers\Api\V1\AuthController::class, 'logout']);

        Route::get('me', [\App\Http\Controllers\Api\V1\UserController::class, 'me']);

        Route::get('articles/{id}/comments', [\App\Http\Controllers\Api\V1\CommentController::class, 'index']);
        Route::post('articles/{id}/comments', [\App\Http\Controllers\Api\V1\CommentController::class, 'store']);
        Route::apiResource('articles', \App\Http\Controllers\Api\V1\ArticleController::class)->only(['index', 'store', 'update', 'destroy']);

        Route::get('tweets/{id}/comments', [\App\Http\Controllers\Api\V1\CommentController::class, 'index']);
        Route::post('tweets/{id}/comments', [\App\Http\Controllers\Api\V1\CommentController::class, 'store']);
        Route::apiResource('tweets', \App\Http\Controllers\Api\V1\TweetController::class)->only(['index', 'store', 'update', 'destroy']);

        Route::apiResource('pages', \App\Http\Controllers\Api\V1\PageController::class)->only(['index', 'store', 'update', 'destroy']);

        Route::apiResource('tags', \App\Http\Controllers\Api\V1\TagController::class)->only(['index', 'store']);

        Route::apiResource('categories', \App\Http\Controllers\Api\V1\CategoryController::class)->only(['index', 'store']);
    });
