<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'owner',
        'count'
    ];
    
    public function user()
    {
        return belongsTo('App\Models\User', 'owner');
    }
    
    public function groupMembers()
    {
        return hasMany('App\Models\GroupMember', 'group_id');
    }

    public function scopeWithUser($query)
    {
        return $query->with('user');
    }
    
    public function scopeHasUser($query, $user_id)
    {
        return $query->whereHas('groupMembers', function($query2) use ($user_id) {
            $query2->whereUser($user_id);
        });
    }
    
}
