<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Post extends Model
{
    protected $table = 'posts';
    
    protected $fillable = [
        'id',
        'is_comment',
        'parent_id',
        'parent_on',
        'user_id',
        'problem_id',
        'title',
        'content',
        'created_at',
        'updated_at',
    ];
    protected $dates = ['created_at', 'updated_at'];
    
    protected $guarded = [ ];
    
    static public $listColumns = [
        'id',
        'is_comment',
        'parent_id',
        'parent_on',
        'user_id',
        'problem_id',
        'title',
        'content',
        'created_at',
        'updated_at'
    ];
    
    static public $editable = [
        'parent_id',
        'parent_on',
        'problem_id',
        'title',
        'content',
    ];

    // Relations
    
    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    
    public function problem() {
        return $this->belongsTo('App\Models\Problem', 'problem_id');
    }
    
    // Accessors & Mutators
    
    public function setCategoryAttribute($value) {
        $this->attributes['parent_id'] = $value;
    }
    
    // Scopes
    
    public function scopeList($query)
    {
        return $query->select(Post::$listColumns);
    }
    
    public function scopeCommentsOf($query, $parent_id)
    {
        return $query->where('is_comment', true)
                     ->where('parent_id', $parent_id)
                     ->orderBy('created_at');
    }
    
    public function scopeOnPost($query)
    {
        return $query->where('is_comment', false)
                     ->where('parent_on', 'post')
                     ->orderBy('created_at', 'desc');
    }
    
    public function scopeOnProblem($query)
    {
        return $query->where('is_comment', false)
                     ->where('parent_on', 'problem')
                     ->orderBy('created_at', 'desc');
    }
    
    public function scopeWhereProblem($query, $problem_id)
    {
        return $query->where('problem_id', $problem_id);
    }
    
    public function scopeWithUser($query)
    {
        return $query->with('user');
    }
    
}
