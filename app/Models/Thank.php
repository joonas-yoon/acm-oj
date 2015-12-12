<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thank extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'thanks';

    protected $fillable = [
        'id',
        'name'
    ];

    const authorCode = 1;

    // Relation

    public function problems() {
        return $this->hasMany('App\Models\Problem');
    }

    public function users() {
        return $this->hasMany('App\Models\User');
    }
}
