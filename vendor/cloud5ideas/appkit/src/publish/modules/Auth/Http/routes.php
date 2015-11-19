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

/**
 * Authentication Routes
 *
 **/
Route::get('auth/login', 		['as' => 'auth.get.login', 		'uses' => 'AuthController@getLogin']);
Route::post('auth/login', 		['as' => 'auth.post.login', 	'uses' => 'AuthController@postLogin']);
Route::get('auth/register', 	['as' => 'auth.get.register', 	'uses' => 'AuthController@getRegister']);
Route::post('auth/register', 	['as' => 'auth.post.register', 	'uses' => 'AuthController@postRegister']);
Route::get('auth/logout', 		['as' => 'auth.get.logout', 	'uses' => 'AuthController@getLogout']);

/**
 * Password reset Routes
 *
 **/
Route::get('password/email', 	['as' => 'password.get.email', 	'uses' => 'PasswordController@getEmail']);
Route::post('password/email', 	['as' => 'password.post.email', 'uses' => 'PasswordController@postEmail']);
Route::get('password/reset', 	['as' => 'password.get.reset', 	'uses' => 'PasswordController@getReset']);
Route::post('password/reset', 	['as' => 'password.post.reset', 'uses' => 'PasswordController@postReset']);
