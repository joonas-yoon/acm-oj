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

// Disable checkpoints (throttling, activation) for demo purposes
Sentinel::disableCheckpoints();

Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');

# Admin Routes
Route::group(['before' => 'auth|admin'], function()
{
    //Route::get('/admin', ['as' => 'admin.dashboard', 'uses' => 'AdminController@getHome']);
    //Route::resource('admin/profiles', 'AdminUsersController', ['only' => ['index', 'show', 'edit', 'update', 'destroy']]);
});

Route::resource('articles', 'ArticlesController');

Route::get ('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');
Route::get ('logout', function(){
    Sentinel::logout();
    return Redirect::back();
});
Route::get ('register', 'Auth\AuthController@getRegister');
Route::post('register', 'Auth\AuthController@PostRegister');

Route::group(['prefix' => 'problems'], function()
{
    Route::group(['prefix' => 'create'], function()
    {
        Route::post('/', [
            'as'   => 'problems.store',
            'uses' => 'ProblemsController@store'
        ]);
        Route::get('list', [
            'as'   => 'problems.create.index',
            'uses' => 'ProblemsController@creatingProblemsList'
        ]);
        Route::post('data', [
            'as'   => 'problems.store.data',
            'uses' => 'ProblemsController@storeData'
        ]);
        Route::get('{step?}', [
            'as'   => 'problems.create',
            'uses' => 'ProblemsController@create'
        ]);
    });
    Route::get('new', 'ProblemsController@newProblems');
    Route::get('preview/{id?}', 'ProblemsController@preview');
    Route::post('{problems}/status', 'ProblemsController@updateStatus');
});

Route::resource('problems', 'ProblemsController');

Route::get('/rank', 'RankController@index');

Route::get('/solutions',  'SolutionsController@index');
Route::post('/solutions', 'SolutionsController@store');
Route::get('/solutions/{id}', 'SolutionsController@show');
Route::get('/submit/{id}','SolutionsController@create');

