<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SolutionResult extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'solution_results';

    protected $fillable = [
        'id',
        'description'
    ];

    protected $hidden = [ 'remark' ];

    public function solution(){
        return $this->hasMany('App\Solution');
    }
}
