<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'problems';

    protected $fillable = [
        'title',
        'description',
        'input',
        'output',
        'sample_input',
        'sample_output',
        'hint',
        'time_limit',
        'memory_limit'
    ];

    public function contributors() {
        //return $this->belongsTo('App\
    }
}
