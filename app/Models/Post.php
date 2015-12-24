<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Post extends Model
{
    protected $table = 'posts';
    
    protected $fillable = [
        'id',
        // is_comment: 0 => parent_id: group_id or category_id
        // is_comment: 1 => parent_id: post_id
        'is_comment',
        'parent_id',
        'user_id',
        'problem_id',
        'title',
        'content',
        'created_at',
        'updated_at',
    ];
    
    protected $guarded = [ ];
    
    static public $listColumns = [
        'id',
        'is_comment',
        'user_id',
        'problem_id',
        'title',
        'content',
        'created_at',
        'updated_at'
    ];
    
    static public $editable = [
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
    
    public function scopeWithUser($query)
    {
        return $query->with('user');
    }
    
    public function scopeWhereProblem($query, $problem_id)
    {
        return $query->where('problem_id', $problem_id);
    }
    
    public function scopeList($query)
    {
        return $query->select(Post::$listColumns);
    }
}
