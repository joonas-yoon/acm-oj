<?php

namespace App\Models;

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
        'time_limit',
        'memory_limit',
        'input',
        'output',
        'sample_input',
        'sample_output',
        'hint',
        'status',
        'total_submit',
        'is_special'
    ];

    static public $listColumns = [
        'id',
        'title',
        'total_submit',
        'status',
        'is_special'
    ];
    
    const hiddenCode = 0;
    const openCode = 1;
    const readyCode = 3;

    // Relation

    public function solutions()
    {
        return $this->hasMany('App\Models\Solution');
    }

    public function problemStatistics()
    {
        return $this->hasMany('App\Models\ProblemStatistics');
    }
    
    public function statistics()
    {
        return $this->hasMany('App\Models\Statistics');
    }
    
    public function problemThank()
    {
        return $this->hasMany('App\Models\ProblemThank', 'problem_id');
    }
    
    public function problemTag()
    {
        return $this->hasMany('App\Models\ProblemTag');
    }

}
