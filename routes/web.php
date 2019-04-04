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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => "auth"], function () {

    Route::get('/users', 'UserController@index')->name('users');
    Route::get('/user-create', 'UserController@create')->name('user.create');
    Route::get('/user-show/{id?}', 'UserController@show')->name('user.show');
    Route::get('/user-edit/{id?}', 'UserController@edit')->name('user.edit');
    Route::delete('/user-delete/{id?}', 'UserController@destroy')->name('user.destroy');
    Route::post('/user-save', 'UserController@store')->name('user.store');

    /*
     * post route start here*/
    Route::get('/posts', 'PostController@index')->name('posts');
    Route::get('/post-create', 'PostController@create')->name('post.create');
    Route::get('/post-show/{id?}', 'PostController@show')->name('post.show');
    Route::get('/post-edit/{id?}', 'PostController@edit')->name('post.edit');
    Route::delete('/post-delete/{id?}', 'PostController@destroy')->name('post.destroy');
    Route::post('/post-save', 'PostController@store')->name('post.store');
    Route::get('/post-comment/{id?}', 'PostController@comment')->name('post.comment');
    Route::get('/post-comment-edit/{id?}', 'PostController@editComment')->name('post.comment.edit');
    Route::post('/post-store-comment', 'PostController@storeComment')->name('post.comment.store');
});

