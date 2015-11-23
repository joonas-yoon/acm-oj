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
}
