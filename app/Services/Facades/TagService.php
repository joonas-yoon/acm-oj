<?php

namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;

class TagService extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'TagService';
    }
}
