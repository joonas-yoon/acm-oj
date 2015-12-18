<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupMember extends Model
{
    protected $table = 'group_members';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'group_id',
        'user_id',
        'level'
    ];
    
    public function user()
    {
        return belongsTo('App\Models\User', 'user_id');
    }
    
    public function group()
    {
        return belongsTo('App\Models\Group', 'group_id');
    }
    
    public function scopeWithUser($query)
    {
        return $query->with('user');
    }
    
    public function scopeWhereGroup($query, $group_id)
    {
        return $query->where('group_id', $group_id);
    }
    
    public function scopeWhereUser($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }
    
}
