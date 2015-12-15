<?php

namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;

class UserService extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'UserService';
    }
}
