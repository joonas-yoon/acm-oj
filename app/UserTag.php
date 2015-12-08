<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class UserTag extends Model
{
    protected $table = 'user_tag';

    public $timestamps = false;


    protected $fillable = [
        'id',
        'user_id',
        'problem_id',
        'tag_id'
    ];

    public function problemTag() {
        return $this->belongsTo('App\ProblemTag');
    }

    public static function deleteTags($user_id, $problem_id) {
        $userTags = UserTag::where('user_id', $user_id)
            ->where('problem_id', $problem_id)->get();
        
        
        foreach($userTags as $userTag) {
            DB::beginTransaction();
            try {
                ProblemTag::first(['problem_id' => $userTag->problem_id, 'tag_id' => $userTag->tag_id])->subTag();
                $userTag->delete();
            } catch(\Exception $e) {
                DB::rollback();
            }
            DB::commit();
        }
    }

    public static function insertTags($user_id, $problem_id, array $tags) {
        
        UserTag::deleteTags($user_id, $problem_id, $tags);
        
        
        foreach($tags as $tag_id) {
            $problemTag = ProblemTag::firstOrCreate([
                'problem_id' => $problem_id,
                'tag_id' => $tag_id
            ]);
            
            DB::beginTransaction();
            try {
                UserTag::create([
                    'user_id' => $user_id,
                    'problem_id' => $problem_id,
                    'tag_id' => $tag_id
                ]);
                $problemTag->addTag();
            } catch(\Exception $e) {
                DB::rollback();
            }
            DB::commit();
        }
    }
}
