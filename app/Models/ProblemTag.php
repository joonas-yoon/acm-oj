<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    
    public function tags()
    {
        return $this->belongsTo('App\Models\Tag', 'tag_id');
    }

    public function problems()
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
}
