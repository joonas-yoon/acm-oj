<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
    protected $table = 'contests';

    protected $fillable = [
        'id',
        'title',
        'creator',
        'group_id',
        'start',
        'end'
    ];
    
    public function user()
    {
        return belongsTo('App\Models\User', 'creator');
    }
    
    public function group()
    {
        return belongsTo('App\Models\Group', 'group_id');
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
