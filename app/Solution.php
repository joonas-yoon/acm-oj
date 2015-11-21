<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solution extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'solutions';

    protected $fillable = [
        'id',
        'lang_id',
        'problem_id',
        'user_id',
        'time',
        'memory',
        'size',
        'is_hidden',
        'created_at',
        'result_id'
    ];

    public function problem() {
        return $this->belongsTo('App\Problem');
    }

    public function result() {
        // get result from solution_results
    }
}
