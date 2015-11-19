<?php namespace C5\AppKit\Exceptions;

/**
 * License: MIT
 * Github: https://github.com/laracasts
 * Copyright (c) 2014 Jeffrey Way [jeffrey@jeffrey-way.com]
 * @package laracasts/utilities
 */
class JavaScriptException extends \Exception {

    /**
     * The exception message.
     *
     * @var string
     */
    protected $message =
        'JavaScript configuration must be published. Use: "php artisan appkit:publish --tag=\"config\"".';
}