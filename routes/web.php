<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Auth::routes();

Route::get('/admin/', 'AdminController@index');


//Login
Route::get('/login/yahoo', 'SocialLoginController@yahoo_auth');
Route::get('/callback/yahoo', 'SocialLoginController@yahoo_callback');
