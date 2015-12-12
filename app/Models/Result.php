<?php

namespace App\Models;

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

    const acceptCode = 4;
    const runningCode = 3;
    const waitCode = 2;
    const tempCode = 1;

    public function solutions(){
        return $this->hasMany('App\Models\Solution', 'result_id');
    }
    
    public function scopeGetOpenResults(){
        return $this->whereNotIn('id', $this->getHiddenCodes());
    }

    public static function getHiddenCodes() {
        return [
            0,  // id가 0인 것은 없음
            \App\Result::getTempCode(),
            // \App\Result::getWaitCode()
        ];
    }
}
