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

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function resultToHtml() {
        // 임시로 설정
        $className = ['waiting', 'accept', 'wrong', 'compile', 'runtime', 'etc'];
        $resultStr = ['기다리는 중...', '맞았습니다!', '틀렸습니다', '컴파일 실패', '런타임 에러', '관리자에게 문의하세요'];
        return "<span class=\"solution {$className[$this->result_id]}\">{$resultStr[$this->result_id]}</span>";
    }

}
