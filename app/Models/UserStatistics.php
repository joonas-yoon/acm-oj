<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserStatistics extends Model
{
    protected $table = 'user_statistics';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'result_id',
        'count'
    ];
}
