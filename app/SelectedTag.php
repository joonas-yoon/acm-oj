<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SelectedTag extends Model
{
    protected $table = 'selected_tag';

    public $primaryKey = 'problem_tag_id';

    protected $fillable = [
        'problem_tag_id',
        'problem_id'
    ];

    public static $limit_select = 3;

    public static function rankUp($problemTag) {
        SelectedTag::firstOrCreate(['problem_tag_id' => $problemTag->id, 'problem_id' => $problemTag->problem_id]);
        $removeTag = SelectedTag::join('problem_tag', function($join) {
            $join->on('selected_tag.problem_tag_id', '=', 'problem_tag.id');
        })->where('selected_tag.problem_id', $problemTag->problem_id)->orderBy('problem_tag.count', 'desc')->offset(SelectedTag::$limit_select)->first();
        if($removeTag)
            $removeTag->delete();
    }
    
    public function tags() {
        return 
    }

    public function scopeGetTags($query) {
        return $query->take(SelectedTag::$limit_select);
    }

}
