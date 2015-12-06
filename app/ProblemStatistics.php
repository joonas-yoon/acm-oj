<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProblemStatistics extends Model
{
    protected $table = 'problem_statistics';

    protected $fillable = [
        'problem_id',
        'result_id',
        'count'
    ];

    public static function getCountOrZero($query) {
        if($query)
            return $query->count;
        return 0;
    }
}
