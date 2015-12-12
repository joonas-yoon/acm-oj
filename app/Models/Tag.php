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

    public static function createTag($name) {
        return Tag::create([
            'name' => $name
        ]);
    }

    public function scopeGetOpenTags($query) {
        return $query->where('status', 1);
    }
}
