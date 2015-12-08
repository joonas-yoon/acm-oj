<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProblemTag extends Model
{
    protected $table = 'problem_tag';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'problem_id',
        'tag_id',
        'count'
    ];

    public function subTag() {
        return $this->decrement('count');
    }

    public function addTag() {
        return $this->increment('count');
    }
}
