<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'results';

    protected $fillable = [
        'id',
        'description',
        'class_name',
        'published'
    ];

    protected $guarded = [
        'remark'
    ];

    const acceptCode = 4;
    const runningCode = 3;
    const waitCode = 2;
    const tempCode = 1;

    public function solutions()
    {
        return $this->hasMany('App\Models\Solution', 'result_id');
    }
    
    public function userStatisticses()
    {
        return $this->hasMany('App\Models\UserStatistics', 'result_id');
    }

    public function scopeWithUserStatistics($query, $user_id)
    {
        return $query->with(['userStatisticses' => function($query2) use ($user_id) {
            $query2->whereUser($user_id);
        }]);
    }
    
    public function scopeWhereResultUp($query, $count)
    {
        return $query->where('id', '>', $count);
    }
    
    public function scopeWherePublished($query, $tf)
    {
        return $query->where('published', $tf);
    }

}
