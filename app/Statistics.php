<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statistics extends Model
{
    protected $table = 'statistics';

    public $timestamps = false;

    protected $fillable = [
        'problem_id',
        'user_id',
        'result_id',
        'count'
    ];

    public static function getCountOrZero($query) {
        if($query)
            return $query->count;
        return 0;
    }
}
