<?php namespace C5\AppKit\Flash;

/**
 * License: MIT
 * Github: https://github.com/laracasts
 * @package laracasts/flash
 */
interface FlashSessionStore {

    /**
     * Flash a message to the session.
     *
     * @param $name
     * @param $data
     */
    public function flash($name, $data);

} 