<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProblemThank extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'problem_thank';

    public $timestamps = false;

    protected $fillable = [
        'problem_id',
        'thank_id',
        'user_id'
    ];

    public function thanks() {
        return $this->belongsTo('thanks');
    }

    public function problems() {
        return $this->belongsTo('problems');
    }


}