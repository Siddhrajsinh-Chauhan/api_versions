<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
/*
 * api route start here
 * */
Route::group(["prefix"=>"v1", "namespace" => "Api\\v1"], function() {
	Route::post('login', 'LoginController@login');
    Route::group(["middleware"=> ["apiAuth"]], function() {
        Route::get('users', 'UserController@index');
        Route::get('logout', 'LoginController@logout');
    });
});

Route::group(["prefix"=>"v2", "namespace" => "Api\\v2"], function() {
	Route::post('login', 'LoginController@login');
    Route::group(["middleware"=> ["apiAuth"]], function() {
        Route::get('users', 'UserController@index');
        Route::get('logout', 'LoginController@logout');
    });
});

Route::group(["prefix"=>"v3", "namespace" => "Api\\v3"], function() {
	Route::post('login', 'LoginController@login');
    Route::group(["middleware"=> ["apiAuth"]], function() {
        Route::get('users', 'UserController@index');
        Route::get('logout', 'LoginController@logout');
    });
});