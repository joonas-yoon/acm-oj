<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'results';

    protected $fillable = [
        'id',
        'description',
        'class_name',
        'published'
    ];

    protected $guarded = [
        'remark'
    ];

    public function solution(){
        return $this->hasMany('App\Solution');
    }

    public static function getTempCode() { return 1; }
    public static function getWaitCode() { return 2; }
    public static function getRunningCode() { return 3; }
    public static function getAcceptCode() { return 4; }

    public static function getHiddenCodes() {
        return [
            0,  // id가 0인 것은 없음
            \App\Result::getTempCode(),
            // \App\Result::getWaitCode()
        ];
    }
}
