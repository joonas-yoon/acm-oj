<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Tag,
    App\Models\Result;

class ProblemTag extends Model
{
    protected $table = 'problem_tag';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'problem_id',
        'tag_id',
        'count'
    ];
    
    public function tag()
    {
        return $this->belongsTo('App\Models\Tag', 'tag_id');
    }

    public function problem()
    {
        return $this->belongsTo('App\Models\Problem', 'problem_id');
    }

    public function subTag() 
    {
        return $this->decrement('count');
    }

    public function addTag() 
    {
        return $this->increment('count');
    }
    
    public function scopeSetTake($query, $take)
    {
        if($take)
            return $query->take($take);
        return $query;
    }
    
    public function scopeWhereProblem($query, $problem_id)
    {
        return $query->where('problem_id', $problem_id);
    }
    
    public function scopeWhereTag($query, $tag_id)
    {
        return $query->where('tag_id', $tag_id);
    }
    
    public function scopeWhereCountUp($query, $count)
    {
        return $query->where('count', '>', $count);
    }

    public function scopeHasTagStatus($query, $status)
    {
        return $query->whereHas('tag', function($query2) use ($status) {
                        $query2->where('status', $status);
                     });
    }
    
    public function scopeHasProblemStatus($query, $status)
    {
        return $query->whereHas('problem', function($query2) use ($status) {
                        $query2->where('status', $status);
                     });
    }
    
    public function scopeWithProblem($query, $user_id)
    {
        return $query->with(['problem' => function($query2) use ($user_id) {
                        $query2->list()->withStatistics($user_id, Result::acceptCode);
                     }]);
    }
    
    public function scopeWithTag($query)
    {
        return $query->with('tag');
    }
    
    public function scopeOrderByCount($query, $order)
    {
        return $query->orderBy('count', $order);
    }
}
