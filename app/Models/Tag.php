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

    public function scopeGetOpenTags($query) {
        return $query->where('status', 1);
    }
}
