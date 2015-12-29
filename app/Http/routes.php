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

Route::get('/', function(){return view('pages.index');});
Route::get('/about', function(){return view('pages.about');});
Route::get('/example', function(){return view('example');});

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
            'as'   => 'problems.create.list',
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
    Route::get('new', [
        'as'   => 'problems.index.new',
        'uses' => 'ProblemsController@newProblems'
    ]);
    Route::get('preview/{id}', [
        'as'   => 'problems.preview',
        'uses' => 'ProblemsController@preview'
    ]);
    
    Route::post('{problems}/status',          'ProblemsController@updateStatus');
    Route::get ('{problems}/publish/{status?}', 'ProblemsController@publish');
    Route::post('{problems}/insert/tag',      'ProblemsController@insertTags');
    Route::get ('{problems}/download/data',   'ProblemsController@downloadData');
});

Route::resource('problems', 'ProblemsController');

Route::group(['prefix' => 'tags', 'as' => 'tags'], function()
{
    Route::get('/', 'TagsController@index')->name('.index');
    
    Route::pattern('id', '[0-9]+');
    Route::group(['prefix' => '{id}'], function()
    {
        Route::get('/', 'TagsController@show')->name('.show');
        Route::get('problems', 'TagsController@problems')->name('.problems');
        Route::get('publish/{yes?}', 'TagsController@publish')->name('.publish');
    });
});

Route::get('/rank', 'RankController@index');

Route::group(['prefix' => 'solutions', 'as' => 'solutions'], function()
{
    Route::get('/',  'SolutionsController@index')->name('.index');
    Route::post('/', 'SolutionsController@store')->name('.store');
    Route::get('{id}', 'SolutionsController@show')->name('.show');
});
Route::get('/submit/{id}','ProblemsController@createSolution')
     ->name('problems.submit');

Route::group(['prefix' => 'user', 'as' => 'user'], function()
{
    Route::get('/', function(){
        return redirect( action('RankController@index') );
    });
    Route::get('{username}', 'UsersController@show')->name('.show');
});

Route::group(['prefix' => 'settings', 'as' => 'settings'], function()
{
    Route::get  ('/', 'UsersController@showSettings')->name('.index');
    Route::patch('/', 'UsersController@postUpdateProfile');
    
    Route::get  ('language', 'UsersController@showDefaultLanguage')->name('.language');
    Route::patch('language', 'UsersController@postDefaultLanguage')->name('.language');
    
    Route::get ('privacy', 'UsersController@showPrivacy')->name('.privacy');
    Route::post('privacy', 'UsersController@postPrivacy')->name('.privacy');
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
    
    Route::get  ('change', 'UsersController@showChangePassword');
    Route::patch('change', 'UsersController@postChangePassword');
    Route::get ('reset', 'UsersController@showResetPassword');
    Route::post('reset/{key}', 'UsersController@postResetPassword');
});

Route::group(['prefix' => 'sessions', 'as' => 'sessions'], function()
{
    Route::get ('/', 'UsersController@showSessions');
    
    Route::get('kill', function() {
        $user = Sentinel::getUser();
        Sentinel::getPersistenceRepository()->flush($user);
        return Redirect::back();
    });

    Route::get('kill-all', function() {
        $user = Sentinel::getUser();
        Sentinel::getPersistenceRepository()->flush($user, false);
        return Redirect::back();
    });

    Route::get('kill/{code}', function($code) {
        Sentinel::getPersistenceRepository()->remove($code);
        return Redirect::back();
    });
});

Route::group(['prefix' => 'posts', 'as' => 'posts'], function()
{
    Route::get('/', function(){return Redirect::route('posts.list');});
    
    Route::group(['prefix' => 'list', 'as' => '.list'], function()
    {
        Route::get('/', 'PostsController@index');
    });
    
    Route::get('create', 'PostsController@create')
         ->name('.create');
    Route::put('create', 'PostsController@store')
         ->name('.store');
    Route::put('create/reply', 'PostsController@storeComment')
         ->name('.reply');
         
    Route::get('{id}', 'PostsController@show')
         ->name('.show');
    Route::patch('{id}', 'PostsController@update')
         ->name('.update');
    Route::delete('{id}', 'PostsController@destroy')
         ->name('.destroy');
         
    Route::get('{id}/edit', 'PostsController@edit')
         ->name('.edit');
    Route::get('{id}/delete', 'PostsController@delete')
         ->name('.delete');
});

Route::group(['prefix' => 'admin', 'as' => 'admin', 'middleware' => 'admin'], function()
{
    Route::group(['prefix' => 'problems'], function()
    {
        Route::get('/', 'AdminController@problems');
        Route::get('thanks', 'AdminController@problemsThanks');
        Route::get('rejudge', 'AdminController@rejudge');
        Route::post('rejudge', 'AdminController@processRejudge');
    });
    
    Route::get('/', 'AdminController@index');
    Route::get('tags', 'AdminController@tags');
});