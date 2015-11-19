<?php namespace C5\AppKit\Middleware;

use Closure;

/**
 * License: MIT
 * Copyright (c) 2015 Charl Gottschalk
 * Github: https://github.com/Cloud5Ideas
 * @package cloud5ideas/appkit
 */
class Register {

	/**
	 * Create a new filter instance.
	 *
	 * @return void
	 */
	public function __construct()
	{

	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (!config('appkit.allow_registration'))
		{
			if (config('appkit.register_404')) {
				abort('404');
			}
			return redirect()->route('home');
		}

		return $next($request);
	}

}
