<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProblemStatistics extends Model
{
    protected $table = 'problem_statistics';

    public $timestamps = false;

    protected $fillable = [
        'problem_id',
        'result_id',
        'count'
    ];

}
