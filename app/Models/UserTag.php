<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTag extends Model
{
    protected $table = 'user_tag';

    public $timestamps = false;


    protected $fillable = [
        'id',
        'user_id',
        'problem_id',
        'tag_id'
    ];

    public function problemTag() {
        return $this->belongsTo('App\Models\ProblemTag');
    }
}
