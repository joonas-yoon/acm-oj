<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Thank;

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
        'is_special',
        'updated_at'
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
        return $this->hasMany('App\Models\Solution', 'problem_id');
    }

    public function problemStatisticses()
    {
        return $this->hasMany('App\Models\ProblemStatistics', 'problem_id');
    }
    
    public function statisticses()
    {
        return $this->hasMany('App\Models\Statistics', 'problem_id');
    }
    
    public function thanks()
    {
        return $this->belongsToMany('App\Models\Thank', 'problem_thank', 'problem_id', 'thank_id');
    }
    
    public function problemTags()
    {
        return $this->hasMany('App\Models\ProblemTag', 'problem_id');
    }
    
    public function problemThanks()
    {
        return $this->hasMany('App\Models\ProblemThank', 'problem_id');
    }
    
    public function user()
    {
        return $this->belongsToMany('App\Models\User', 'problem_thank', 'problem_id','user_id')
                    ->wherePivot('thank_id', Thank::authorCode);
    }
    
    public function scopeWithUser($query)
    {
        return $query->with('user');
    }
    
    public function scopeWhereProblem($query, $problem_id)
    {
        return $query->where('id', $problem_id);
    }
    
    public function scopeWithProblemThank($query)
    {
        return $query->with(['problemThanks' => function ($query2) {
            $query2->withThank()->withUser();
        }]);
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
    
    public function scopeInStatus($query, array $status)
    {
        return $query->whereIn('status', $status);
    }
    
    public function scopeList($query)
    {
        return $query->select(Problem::$listColumns);
    }

    public function scopeHasUser($query, $user_id, $thank_id)
    {
        return $query->whereHas('problemThanks', function($query2) use ($user_id, $thank_id) {
           $query2->whereUser($user_id)->whereThank($thank_id); 
        });
    }
}
