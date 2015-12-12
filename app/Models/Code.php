<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    protected $table = 'codes';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'code'
    ];
}
