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

    public function scopeWhereProblem($query, $problem_id)
    {
        return $query->where('problem_id', $problem_id);
    }
    
    public function scopeWhereResult($query, $result_id)
    {
        return $query->where('result_id', $result_id);
    }

}
