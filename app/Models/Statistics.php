<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statistics extends Model
{
    protected $table = 'statistics';

    public $timestamps = false;

    protected $fillable = [
        'problem_id',
        'user_id',
        'result_id',
        'count'
    ];

    public function problems() {
        return $this->belongsTo('App\Models\Problem', 'problem_id');
    }

}
