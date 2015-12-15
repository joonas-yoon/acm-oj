<?php

namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;

class StatisticsService extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'StatisticsService';
    }
}
