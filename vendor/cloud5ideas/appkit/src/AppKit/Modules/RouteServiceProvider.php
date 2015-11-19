<?php
namespace C5\AppKit\Modules;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

/**
 * License: MIT
 * Copyright (c) 2015 Shea Lewis
 * Github: https://github.com/caffeinated
 * @package caffeinated/modules
 */
abstract class RouteServiceProvider extends ServiceProvider
{
	/**
	 * Set the root controller namespace for the application.
	 *
	 * @return void
	 */
	protected function setRootControllerNamespace()
	{
		// Intentionally left empty to prevent overwriting the
		// root controller namespace.
	}	
}