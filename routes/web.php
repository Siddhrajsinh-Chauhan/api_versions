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

Route::group(['middleware'=>"auth"], function(){

	Route::get('/users', 'UserController@index')->name('users');
	Route::get('/user-create', 'UserController@create')->name('user.create');
	Route::get('/user-show/{id?}', 'UserController@show')->name('user.show');
	Route::get('/user-edit/{id?}', 'UserController@edit')->name('user.edit');
	Route::get('/user-delete/{id?}', 'UserController@destroy')->name('user.destroy');
	Route::post('/user-save', 'UserController@store')->name('user.store');
});

/*Route::group(["prefix"=>"api/v1","namespace" => "Api\\v1"], function(){
	Route::get('login', 'LoginController@login');
});*/