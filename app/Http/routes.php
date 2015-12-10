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
Route::get('/example', function(){return view('example');});

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

Route::group(['prefix' => 'user', 'as' => 'user'], function()
{
    Route::get('/', function(){
        return redirect( action('RankController@index') );
    });
    Route::get('{username}', 'UsersController@show');
});

Route::group(['prefix' => 'settings', 'as' => 'settings'], function()
{
    Route::get  ('/', 'UsersController@showSettings');
    Route::patch('/', 'UsersController@postUpdateProfile');
    
    Route::get ('language', 'UsersController@showDefaultLanguage');
    Route::post('language', 'UsersController@postDefaultLanguage');
    
    Route::get ('privacy', 'UsersController@showPrivacy');
    Route::post('privacy', 'UsersController@postPrivacy');
    
    Route::group(['middleware' => 'admin'], function()
    {
        // Route::get ('/', 'UsersController@settings');
    });
});

Route::group(['prefix' => 'images'], function()
{
    Route::get('profile/{filename}', function ($filename)
    {
        if(!File::exists( $filename = storage_path("app/images/profile/{$filename}") )) abort(404);
        return Image::make($filename)->response();
    });
});

Route::post('upload/photo', 'UsersController@uploadPhoto');

Route::group(['prefix' => 'password', 'as' => 'password'], function()
{
    Route::get('/', function(){ return redirect('/password/reset'); });
    
    Route::get ('change', 'UsersController@showChangePassword');
    Route::post('change', 'UsersController@postChangePassword');
    Route::get ('reset', 'UsersController@showResetPassword');
    Route::post('reset/{key}', 'UsersController@postResetPassword');
});