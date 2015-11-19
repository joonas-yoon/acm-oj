<?php namespace C5\AppKit\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

/**
 * License: MIT
 * Copyright (c) 2015 Charl Gottschalk
 * Github: https://github.com/Cloud5Ideas
 * @package cloud5ideas/appkit
 */
class Permission {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next, $params = array())
	{
		$permissions = $this->getPermissions($request);
		if ($this->auth->check() && !$request->user()->can($permissions))
		{
			flash()->error(config('appkit.access_denied_message'));
			return redirect()->route('admin');
		}

		return $next($request);
	}

	/**
	 * Get the required permsissions.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 **/
	private function getPermissions($request)
	{
	    $action = $request->route()->getAction();
	 
	    return $action['permissions'];
	}

}
