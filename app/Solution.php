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
        $cid = $this->result_id ? $this->result_id : 0;

        $className = ['null', 'waiting', 'accept', 'wrong', 'compile', 'runtime', 'etc'];
        $renderStr = ['없음', '기다리는 중...', '맞았습니다!', '틀렸습니다', '컴파일 실패', '런타임 에러', '관리자에게 문의하세요'];

        return "<span class=\"solution {$className[$cid]}\">{$renderStr[$cid]}</span>";
    }

}
