<?php

namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;

class ProblemService extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'ProblemService';
    }
}
