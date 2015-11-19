<?php namespace App\Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use C5\AppKit\Traits\AuthenticatesAndRegistersUsersTrait;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsersTrait;

	/**
	 * The view to use for user registration.
	 *
	 * @string View
	 */
	protected $registrationView = 'auth::register';

	/**
	 * The view to use for user login.
	 *
	 * @string View
	 */
	protected $loginView = 'auth::login';

	/**
	 * The path to redirect to after registration or login.
	 *
	 * @string Url
	 */
	protected $redirectPath = '/';

	/**
	 * The path to redirect to for user login.
	 *
	 * @string Url
	 */
	protected $loginPath = '/auth/login';

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('register', ['only' => 'getRegister']);
		$this->middleware('guest', ['except' => 'getLogout']);
	}

}
