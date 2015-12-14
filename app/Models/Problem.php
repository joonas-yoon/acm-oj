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
    
    static public $editable = [
        'title',
        'description',
        'time_limit',
        'memory_limit',
        'input',
        'output',
        'sample_input',
        'sample_output',
        'hint',
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

    public function problemStatisticses()
    {
        return $this->hasMany('App\Models\ProblemStatistics');
    }
    
    public function statisticses()
    {
        return $this->hasMany('App\Models\Statistics');
    }
    
    public function problemThanks()
    {
        return $this->hasMany('App\Models\ProblemThank', 'problem_id');
    }
    
    public function problemTags()
    {
        return $this->hasMany('App\Models\ProblemTag');
    }
    
    public function scopeWhereProblem($query, $problem_id)
    {
        return $query->where('id', $problem_id);
    }
    
    public function scopeWithStatistics($query, $user_id, $result_id)
    {
        if($user_id == null)
            return $query->with([
                        'problemStatisticses' => function($query2) use ($result_id) {
                        $query2->whereResult($result_id);
                      }]);
    
        return $query->with([
                        'problemStatisticses' => function($query2) use ($result_id) {
                        $query2->whereResult($result_id);
                      },
                        'statisticses' => function($query2) use ($user_id, $result_id) {
                        $query2->whereUser($user_id)
                              ->whereResult($result_id);
                      }]);
    }
    
    public function scopeWhereStatus($query, $status)
    {
        return $query->where('status', $status);
    }
    
    public function scopeList($query)
    {
        return $query->select(Problem::$listColumns);
    }

}
