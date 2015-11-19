<?php namespace C5\AppKit\JavaScript;

/**
 * License: MIT
 * Github: https://github.com/laracasts
 * Copyright (c) 2014 Jeffrey Way [jeffrey@jeffrey-way.com]
 * @package laracasts/utilities
 */
interface ViewBinder
{

    /**
     * Bind the JavaScript variables to the view.
     *
     * @param string $js
     */
    public function bind($js);

} 