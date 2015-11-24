<?php

namespace App;

use Request;
use Illuminate\Database\Eloquent\Model;

class Helpers extends Model
{
    public static function setActive($path, $route = null, $active = 'active')
    {
        if( is_object($route) )
        {
            return $route->getName() == $path ? $active : '';
        }

        return Request::is($path) || Request::is($path.'/*') ? $active : '';
    }

    public static function setActiveStrict($path, $route = null, $active = 'active')
    {
        if( is_object($route) )
        {
            return $route->getName() == $path ? $active : '';
        }

        return Request::is($path) ? $active : '';
    }
}
