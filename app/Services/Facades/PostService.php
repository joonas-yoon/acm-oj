<?php

namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;

class PostService extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'PostService';
    }
}
