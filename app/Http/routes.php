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

Route::post('/problems/create', [
    'as'   => 'problems.store',
    'uses' => 'ProblemsController@store'
]);
Route::get('/problems/create/list', [
    'as'   => 'problems.create.index',
    'uses' => 'ProblemsController@creatingProblemsList'
]);
Route::post('/problems/create/data', [
    'as'   => 'problems.store.data',
    'uses' => 'ProblemsController@storeData'
]);
Route::get('/problems/create/{step?}', [
    'as'   => 'problems.create',
    'uses' => 'ProblemsController@create'
]);
Route::get('/problems/new', 'ProblemsController@newProblems');
Route::get('/problems/preview/{id?}', 'ProblemsController@preview');
Route::post('/problems/{problems}/status', 'ProblemsController@updateStatus');
Route::resource('problems', 'ProblemsController');

Route::get('/user/{name}', 'UsersController@show');

Route::get('/rank', 'RankController@index');

Route::get('/solutions',  'SolutionsController@index');
Route::post('/solutions', 'SolutionsController@store')->middleware('auth');
Route::get('/solutions/{id}', 'SolutionsController@show');
Route::get('/submit/{id}','SolutionsController@create')->middleware('auth');

