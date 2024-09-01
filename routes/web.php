<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home.index');
Route::get('articles', [\App\Http\Controllers\ArticleController::class, 'index'])->name('articles.index');
Route::get('articles/{slug}', [\App\Http\Controllers\ArticleController::class, 'show'])->name('articles.show');
Route::get('pages', [\App\Http\Controllers\PageController::class, 'index'])->name('pages.index');
Route::get('pages/{slug}', [\App\Http\Controllers\PageController::class, 'show'])->name('pages.show');
Route::get('tweets', [\App\Http\Controllers\TweetController::class, 'index'])->name('tweets.index');
Route::get('tweets/{slug}', [\App\Http\Controllers\TweetController::class, 'show'])->name('tweets.show');
Route::get('search', [\App\Http\Controllers\SearchController::class, 'index'])->name('search.index');
Route::get('search/categories/{slug}', [\App\Http\Controllers\SearchController::class, 'categories'])->name('search.categories');
Route::get('search/tags/{slug}', [\App\Http\Controllers\SearchController::class, 'tags'])->name('search.tags');
Route::post('post/{slug}/comments', [\App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
Route::get('users/{id}/articles', [\App\Http\Controllers\UserController::class, 'articles'])->name('users.articles');
Route::get('users/{id}/tweets', [\App\Http\Controllers\UserController::class, 'tweets'])->name('users.tweets');

Route::feeds();
