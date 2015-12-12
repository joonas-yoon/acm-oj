<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Article extends Model
{
    protected $fillable = [
        'title',
        'body',
        'published_at',
        'user_id' // temporary
    ];

    protected $dates = ['published_at'];

    public function scopePublished($query) {
        return $query->where('published_at', '<=', Carbon::now());
    }

    public function scopeUnpublished($query) {
        return $query->where('published_at', '>', Carbon::now());
    }

    public function setPublishedAtAttribute($date) {
        $this->attributes['published_at'] = Carbon::createFromFormat('Y-m-d', $date);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
