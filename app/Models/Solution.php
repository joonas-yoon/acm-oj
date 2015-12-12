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
        'is_hidden',
        'created_at',
    ];

    protected $guarded = [];

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

    public function statistics()
    {
        return $this->hasMany('App\Models\Statistics', 'user_id');
    }

    /**
     * 결과를 Html 형식을 추가하여 반환
     *
     * @param int $result_id
     * @return string
     */
    public function resultToHtml()
    {
        $result = $this->result;
        return "<span class=\"solution {$result->class_name}\">{$result->description}</span>";
    }

}
