<?php namespace App\Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use C5\AppKit\Traits\ResetsPasswordsTrait;

class PasswordController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Password Reset Controller
	|--------------------------------------------------------------------------
	|
	| This controller is responsible for handling password reset requests
	| and uses a simple trait to include this behavior. You're free to
	| explore this trait and override any methods you wish to tweak.
	|
	*/

	use ResetsPasswordsTrait;

	/**
	 * The view to use for users to request a password reset.
	 *
	 * @string View
	 */
	protected $passwordView = 'auth::password';

	/**
	 * The view to use for password reset.
	 *
	 * @string View
	 */
	protected $resetView = 'auth::reset';

	/**
	 * The path to redirect to after action.
	 *
	 * @string Url
	 */
	protected $redirectPath = '/';

	/**
	 * Create a new password controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\PasswordBroker  $passwords
	 * @return void
	 */
	public function __construct(Guard $auth, PasswordBroker $passwords)
	{
		$this->auth = $auth;
		$this->passwords = $passwords;

		$this->middleware('guest');
	}

}
