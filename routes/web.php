<?php

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
Route::get('/', 'HomeController@index')->name('home.index');
Route::get('/archives', 'ArchiveController@index')->name('archive.index');
Route::get('/article/{slug}', 'ArticleController@index')->name('article.index');
Route::get('/tag/{name}', 'TagController@posts');
Route::get('/category/{slug}', 'CategoryController@posts')->name('category.show');
Route::get('/search', 'SearchController@index')->name('search.index');
Route::get('/page/{slug}', 'PageController@show')->name('page.show');
Route::get('/user/{id}', 'UserController@show')->name('author.show');
Route::get('/feed', 'HomeController@feed');
Route::get('/sitemap.xml', 'HomeController@sitemap');
Route::post('/comment', 'CommentController@store')->name('comment.store');

Route::group(['prefix' => 'admin', 'middleware' => ['web', 'auth']], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard.index');

    Route::get('post', 'PostController@index')->middleware(['permission:post.index'])->name('post.index');
    Route::get('post/create', 'PostController@create')->middleware(['permission:post.create'])->name('post.create');
    Route::post('post', 'PostController@store')->name('post.store');
    Route::get('post/{id}/edit', 'PostController@edit')->middleware(['permission:post.edit'])->name('post.edit');
    Route::patch('post/{id}', 'PostController@update')->name('post.update');
    Route::delete('post/{id}', 'PostController@destroy')->middleware(['permission:post.destroy'])->name('post.destroy');

    Route::post('post/upload', 'PostController@uploadImage')->name('post.upload');

    Route::group(['middle' => 'role:admin'], function () {
        Route::resource('tag', 'TagController');
        Route::resource('category', 'CategoryController', ['except' => ['show']]);
        Route::resource('page', 'PageController', ['except' => ['show']]);
        Route::resource('option', 'OptionController', ['except' => ['show']]);
        Route::get('appearance/menu', 'MenuController@index')->name('appearance.menu');
        Route::post('option/menu', 'OptionController@menuStore')->name('option.menu');
        Route::get('option/cache', 'OptionController@cache')->name('option.cache');
        Route::post('option/clearcache', 'OptionController@clearAllCache')->name('option.clearcache');
        Route::get('user', 'UserController@index')->name('user.index');
        Route::delete('comment/{id}', 'CommentController@destroy')->name('comment.destroy');
        Route::get('comment', 'CommentController@index')->name('comment');
    });
    Route::patch('user/{id}', 'UserController@update')->name('user.update');
    Route::get('user/profile/{id}', 'UserController@profile')->name('user.profile');

});

Auth::routes();
