<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTag extends Model
{
    protected $table = 'user_tag';

    public $timestamps = false;


    protected $fillable = [
        'id',
        'user_id',
        'problem_id',
        'tag_id'
    ];
    
    public function tag()
    {
        return $this->belongsTo('App\Models\Tag', 'tag_id');
    }

    public function problem()
    {
        return $this->belongsTo('App\Models\Problem', 'problem_id');
    }
    
    public function scopeWithTag($query)
    {
        return $query->with('tag');
    }
    
    public function scopeWhereUser($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }
    
    public function scopeWhereProblem($query, $problem_id)
    {
        return $query->where('problem_id', $problem_id);
    }
}
