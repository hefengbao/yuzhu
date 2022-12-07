<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home.index');
Route::get('articles', [\App\Http\Controllers\ArticleController::class, 'index'])->name('articles.index');
Route::get('articles/{slug}', [\App\Http\Controllers\ArticleController::class, 'show'])->name('articles.show');
Route::get('pages/{slug}', [\App\Http\Controllers\PageController::class, 'show'])->name('pages.show');
Route::get('tweets', [\App\Http\Controllers\TweetController::class, 'index'])->name('tweets.index');
Route::get('tweets/{slug}', [\App\Http\Controllers\TweetController::class, 'show'])->name('tweets.show');
Route::get('search', [\App\Http\Controllers\SearchController::class, 'index'])->name('search.index');
Route::get('search/categories/{slug}', [\App\Http\Controllers\SearchController::class, 'categories'])->name('search.categories');
Route::get('search/tags/{slug}', [\App\Http\Controllers\SearchController::class, 'tags'])->name('search.tags');
Route::post('post/{slug}/comments', [\App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
Route::get('archives', [\App\Http\Controllers\ArchiveController::class, 'index'])->name('archives.index');

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'verified'], 'as' => 'admin.'], function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard.index');

    Route::put('articles/{id}/pin', [\App\Http\Controllers\Admin\ArticleController::class, 'pin'])->name('articles.pin');
    Route::resource('articles', \App\Http\Controllers\Admin\ArticleController::class)->except(['show']);
    Route::resource('tweets', \App\Http\Controllers\Admin\TweetController::class)->except(['show']);
    Route::resource('pages', \App\Http\Controllers\Admin\PageController::class)->except(['show']);
    Route::resource('tags', \App\Http\Controllers\Admin\TagController::class)->except(['show']);;
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->except(['show']);

    Route::resource('options', \App\Http\Controllers\Admin\OptionController::class)->except(['show']);

    Route::patch('comments/{id}/approve', [\App\Http\Controllers\Admin\CommentController::class, 'approve'])->name('comments.approve');
    Route::patch('comments/{id}/pending', [\App\Http\Controllers\Admin\CommentController::class, 'pending'])->name('comments.pending');
    Route::patch('comments/{id}/spam', [\App\Http\Controllers\Admin\CommentController::class, 'spam'])->name('comments.spam');
    Route::patch('comments/{id}/trash', [\App\Http\Controllers\Admin\CommentController::class, 'trash'])->name('comments.trash');
    Route::patch('comments/{id}/restore', [\App\Http\Controllers\Admin\CommentController::class, 'restore'])->name('comments.restore');
    Route::get('comments', [\App\Http\Controllers\Admin\CommentController::class, 'index'])->name('comments.index');

    Route::get('users/{id}/profile', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->except(['show', 'edit']);
    Route::patch('users/{id}/restore', [\App\Http\Controllers\Admin\UserController::class, 'restore'])->name('users.restore');

    Route::get('editorjs/fetch_url', [\App\Http\Controllers\Admin\EditorjsController::class, 'fetchUrl'])->name('editorjs.fetchurl');
    Route::post('upload/image', [\App\Http\Controllers\Admin\UploadController::class, 'image'])->name('upload.image');
});

Auth::routes(['verify' => true]);

Route::feeds();
