<?php namespace C5\AppKit\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * License: MIT
 * Github: https://github.com/laracasts
 * @package laracasts/flash
 */
class FlashFacade extends Facade {

    /**
     * Get the binding in the IoC container
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'flash';
    }

} 