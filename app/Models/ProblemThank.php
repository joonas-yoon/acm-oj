<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProblemThank extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'problem_thank';

    public $timestamps = false;

    protected $fillable = [
        'problem_id',
        'thank_id',
        'user_id'
    ];

    public function thank() {
        return $this->belongsTo('App\Models\Thank', 'thank_id');
    }

    public function problem() {
        return $this->belongsTo('App\Models\Problem', 'problem_id');
    }

    public function scopeWithProblem($query)
    {
        return $query->with(['problem' => function($query) {
                        $query->list();
                     }]);
    }
    
    public function scopeWhereProblem($query, $problem_id)
    {
        return $query->where('problem_id', $problem_id);
    }
    
    public function scopeWhereUser($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }
    
    public function scopeWhereThank($query, $thank_id)
    {
        return $query->where('thank_id', $thank_id);
    }
    
    public function scopeInProblemStatus($query, array $status)
    {
        return $query->whereHas('problem', function ($query) use ($status) {
                        $query->whereIn('status', $status);
                     });
    }

}