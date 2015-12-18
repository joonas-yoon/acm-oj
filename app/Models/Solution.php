<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Result;

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
        'result_id',
        'lang_id',
        'problem_id',
        'user_id',
        'time',
        'memory',
        'size',
        'is_hidden',    // 채점 현황에서 아예 제거
        'is_published', // 소스 코드 공개 여부
        'created_at',
    ];

    protected $guarded = [];
    
    static public $editable = [
        'result_id',
        'lang_id',
        'problem_id',
        'user_id',
        'size',
        'is_hidden',
        'is_published'
    ];

    public function problem()
    {
        return $this->belongsTo('App\Models\Problem', 'problem_id');
    }

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function language()
    {
        return $this->belongsTo('App\Models\Language', 'lang_id');
    }

    public function code()
    {
        return $this->hasOne('App\Models\Code', 'id');
    }

    public function result()
    {
        return $this->belongsTo('App\Models\Result', 'result_id');
    }

    public function statisticses()
    {
        return $this->hasMany('App\Models\Statistics', 'problem_id', 'problem_id');
    }
    
    public function scopeWithWired($query, $user_id)
    {
        return $query->with([
            'problem' => function($query2) {
                $query2->list();
            },
            'user' => function($query2) {
                $query2->list();
            },
            'result',
            'language',
            'statisticses' => function($query2) use ($user_id) {
                $query2->whereUser($user_id)
                       ->whereResult(Result::acceptCode)
                       ->whereCountUp(0);
        }]);
    }
    
    public function scopeJoinProblem($query)
    {
        return $query->join('problems', function($join) {
                        $join->on('problems.id', '=', 'solutions.problem_id');
                     });
    }
    
    public function scopeJoinUser($query)
    {
        return $query->join('users', function($join) {
                        $join->on('users.id', '=', 'solutions.user_id');
                     });
    }
    
    public function scopeWhereProblem($query, $problem_id)
    {
        return $query->where('problem_id', $problem_id);
    }
    
    public function scopeWhereName($query, $name)
    {
        return $query->where('name', $name);
    }
    
    public function scopeWhereLang($query, $lang_id)
    {
        return $query->where('lang_id', $lang_id);
    }
    
    public function scopeWhereResult($query, $result_id)
    {
        return $query->where('result_id', $result_id);
    }
    
    public function scopeList($query)
    {
        return $query->select('solutions.*');
    }
    
    public function scopeWhereHidden($query, $tf)
    {
        return $query->where('is_hidden', $tf);
    }
    
    public function scopeWhereSolution($query, $solution_id)
    {
        return $query->where('id', $solution_id);
    }

}
