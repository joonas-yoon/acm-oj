<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Result;

class Tag extends Model
{
    protected $table = 'tags';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'status'
    ];
    
    const openCode = 1;
    const hiddenCode = 0;

    public function problemTags()
    {
        return $this->hasMany('App\Models\ProblemTag', 'tag_id');
    }

    public function problemTagCount()
    {
        return $this->hasOne('App\Models\ProblemTag', 'tag_id');
    }

    public function scopeGetOpenTags($query) {
        return $query->where('status', 1);
    }
    
    public function scopeWithProblemTag($query, $status)
    {
        return $query->with(['problemTags' => function($query2) use ($status) {
                        $query2->whereHas('problem', function($query3) use ($status) {
                            $query3->whereStatus($status);
                        });
                    }]);
    }
    
    public function scopeWhereStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
