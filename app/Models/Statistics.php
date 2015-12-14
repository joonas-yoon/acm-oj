<?php

namespace App\Models;

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

    public function problem() {
        return $this->belongsTo('App\Models\Problem', 'problem_id');
    }

    public function scopeWhereProblem($query, $problem_id)
    {
        return $query->where('problem_id', $problem_id);
    }
    
    public function scopeWhereResult($query, $result_id)
    {
        return $query->where('result_id', $result_id);
    }
    
    public function scopeWhereUser($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }
    
    public function scopeWithProblem($query)
    {
        return $query->with(['problem' => function($query) {
                        $query->select('id', 'title');
                     }]);
    }
    
    public function scopeWhereCount($query, $count)
    {
        return $query->where('count', $count);
    }
    
    public function scopeWhereCountUp($query, $count)
    {
        return $query->where('count', '>', $count);
    }
    
    public function scopeHasProblemStatus($query, $status)
    {
        return $query->whereHas('problem', function($query) use ($status) {
                        $query->whereStatus($status);
                     });
    }
}
