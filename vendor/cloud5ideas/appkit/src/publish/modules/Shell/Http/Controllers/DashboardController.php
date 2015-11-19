<?php namespace App\Modules\Shell\Http\Controllers;

use App\Http\Controllers\Controller;

class DashboardController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Dashboard Controller
	|--------------------------------------------------------------------------
	|
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the module index to the user.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		return view('shell::dashboard');
	}

}