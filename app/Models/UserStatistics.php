<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserStatistics extends Model
{
    protected $table = 'user_statistics';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'result_id',
        'count'
    ];
    
    public function scopeWhereUser($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }
    
    public function scopeWhereResult($query, $result_id)
    {
        return $query->where('result_id', $result_id);
    }
}
