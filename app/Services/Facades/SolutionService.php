<?php

namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;

class SolutionService extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'SolutionService';
    }
}
