<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Result;

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

    public function problem() {
        return $this->belongsTo('App\Problem');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function result() {
        return $this->belongsTo('App\Result')->where('id', $this->result_id);
    }

    public function publishedResult() {
        return $this->result->where('published', '!=', 0);
    }

    public function isAccepted() {
        return Result::find($this->result_id)->class_name == "accept";
    }

    public function resultToHtml() {
        $result = Result::find($this->result_id);

        return "<span class=\"solution {$result->class_name}\">{$result->description}</span>";
    }
}
