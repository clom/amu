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

// all user
Route::get('/', 'MainController@index');


// admin
Route::get('/admin/', 'AdminController@index');
Route::get('/admin/place', 'AdminController@place');
Route::get('/admin/time', 'AdminController@timeline');
Route::get('/admin/schedule', 'AdminController@schedule');
Route::get('/admin/change', 'AdminController@changeAdmin');
Route::get('/admin/info', 'AdminController@information');

//api
Route::resource('/api/v1/admin/permission', 'Api\v1\AdminUserController');
Route::resource('/api/v1/admin/place', 'Api\v1\AdminPlaceController');
Route::resource('/api/v1/admin/schedule', 'Api\v1\AdminScheduleController');
Route::resource('/api/v1/admin/time', 'Api\v1\AdminTimeLineController');
Route::resource('/api/v1/admin/info', 'Api\v1\AdminInfoController');

//Login
Auth::routes();
Route::get('/login/yahoo', 'SocialLoginController@yahoo_auth');
Route::get('/callback/yahoo', 'SocialLoginController@yahoo_callback');
