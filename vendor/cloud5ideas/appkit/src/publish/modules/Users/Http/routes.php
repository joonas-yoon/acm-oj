<?php

/*
|--------------------------------------------------------------------------
| Module Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for the module.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::group(['middleware' => 'access', 'permissions' => ['access.users']], function()
{
    Route::get('users/{users}/disable', 	['as' => 'users.disable', 	'uses' => 'UsersController@disable']);
	Route::get('users/{users}/enable', 		['as' => 'users.enable', 	'uses' => 'UsersController@enable']);
	Route::put('users/{users}/password', 	['as' => 'users.password', 	'uses' => 'UsersController@password']);
	Route::put('users/{users}/image', 		['as' => 'users.image', 	'uses' => 'UsersController@image']);
	Route::post('users/search', 			['as' => 'users.search', 	'uses' => 'UsersController@search']);
	Route::resource('users', 'UsersController');
});