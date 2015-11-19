<?php namespace C5\AppKit\Flash;

use Illuminate\Session\Store;

/**
 * License: MIT
 * Github: https://github.com/laracasts
 * @package laracasts/flash
 */
class LaravelSessionStore implements FlashSessionStore {

    /**
     * @var Store
     */
    private $session;

    /**
     * @param Store $session
     */
    function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * Flash a message to the session.
     *
     * @param $name
     * @param $data
     */
    public function flash($name, $data)
    {
        $this->session->flash($name, $data);
    }

}