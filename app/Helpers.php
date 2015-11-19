<?php

namespace App;

use Request;
use Illuminate\Database\Eloquent\Model;

class Helpers extends Model
{
    public static function setActive($path, $active = 'active')
    {
        return Request::is($path) || Request::is($path.'/*') ? $active : '';
    }
}
