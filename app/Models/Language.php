<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'languages';

    protected $fillable = [
        'id',
        'name'
    ];

    public function solutions(){
        return $this->hasMany('App\Models\Solution', 'lang_id');
    }
}
