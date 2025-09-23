<?php

use Illuminate\Support\Facades\Route;

Route::domain(config('domain.api'))
    ->prefix('v1')
    ->name('api.v1.')
    ->group(function () {
        Route::post('auth/login', [\App\Http\Controllers\Api\V1\AuthController::class, 'login']);
        Route::post('auth/logout', [\App\Http\Controllers\Api\V1\AuthController::class, 'logout']);

        Route::get('me', [\App\Http\Controllers\Api\V1\UserController::class, 'me']);

        Route::prefix('cms')
            ->name('cms.')
            ->group(function () {
                Route::get('articles/{id}/comments', [\App\Http\Controllers\Api\V1\CMS\CommentController::class, 'index']);
                Route::post('articles/{id}/comments', [\App\Http\Controllers\Api\V1\CMS\CommentController::class, 'store']);
                Route::apiResource('articles', \App\Http\Controllers\Api\V1\CMS\ArticleController::class)->only(['index', 'store', 'update', 'destroy']);
                Route::get('tweets/{id}/comments', [\App\Http\Controllers\Api\V1\CMS\CommentController::class, 'index']);
                Route::post('tweets/{id}/comments', [\App\Http\Controllers\Api\V1\CMS\CommentController::class, 'store']);
                Route::apiResource('tweets', \App\Http\Controllers\Api\V1\CMS\TweetController::class)->only(['index', 'store', 'update', 'destroy']);
                Route::apiResource('pages', \App\Http\Controllers\Api\V1\CMS\PageController::class)->only(['index', 'store', 'update', 'destroy']);
                Route::apiResource('tags', \App\Http\Controllers\Api\V1\CMS\TagController::class)->only(['index', 'store']);
                Route::apiResource('categories', \App\Http\Controllers\Api\V1\CMS\CategoryController::class)->only(['index', 'store']);
            });

        Route::prefix('fms')
            ->name('fms.')
            ->group(function () {
                Route::apiResource('groups', \App\Http\Controllers\Api\V1\FMS\GroupController::class)->only(['index']);
                Route::apiResource('categories', \App\Http\Controllers\Api\V1\FMS\CategoryController::class)->only(['index']);
                Route::apiResource('transactions', \App\Http\Controllers\Api\V1\FMS\TransactionController::class)->only(['index', 'store', 'update']);
                Route::apiResource('accounts', \App\Http\Controllers\Api\V1\FMS\AccountController::class)->only(['index', 'store', 'update']);
            });
    });
