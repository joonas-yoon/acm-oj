<?php namespace C5\AppKit\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * License: MIT
 * Copyright (c) 2015 Shea Lewis
 * Github: https://github.com/caffeinated
 * @package caffeinated/menus
 */
class MenuFacade extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'menu';
	}
}
