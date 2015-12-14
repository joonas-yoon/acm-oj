<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function problemTag()
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
}
