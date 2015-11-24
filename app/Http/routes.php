<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//DB::listen(function($sql, $bindings, $time){var_dump($sql);});

Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');

Route::resource('articles', 'ArticlesController');

Route::get('/problems/new', 'ProblemsController@newProblems');
Route::post('/problems/create/{step}', 'ProblemsController@createData');
Route::resource('problems', 'ProblemsController');

Route::get('/rank', 'RankController@index');

Route::get('/solutions',  'SolutionsController@index');
Route::post('/solutions', 'SolutionsController@store');
Route::get('/solutions/{id}', 'SolutionsController@show');
Route::get('/submit/{id}','SolutionsController@create');

