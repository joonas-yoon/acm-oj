<?php namespace C5\AppKit\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * License: MIT
 * Github: https://github.com/laracasts
 * Copyright (c) 2014 Jeffrey Way [jeffrey@jeffrey-way.com]
 * @package laracasts/utilities
 */
class JavaScriptFacade extends Facade
{

    /**
     * The name of the binding in the IoC container.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'javascript';
    }
}