<?php

namespace App\Repositories;

use App\Models\ProblemTag,
    App\Models\Tag,
    App\Models\Problem;

class ProblemTagRepository extends BaseRepository
{
    public function __construct(ProblemTag $problemTag)
    {
        $this->model = $problemTag;
    }
    
    public function getPopularTags($problem_id, $take)
    {
        return $this->model->with('tags')->where('problem_id', $problem_id)
                    ->orderBy('count', 'desc')->take(3)->get();
    }
    
    public function getTagWithProblem($tag_id, $paginateCount)
    {
        return $this->model->with('problems', function($query) {
            $query->select(Problem::listColumns)
            ->where('status', Problem::openCode)->orderBy('count', 'desc');
        })->where('tag_id', $tag_id)->paginate($paginateCount);
    }
    
    public function subProblemTag($problem_id, $tag_id)
    {
        $this->model->where('problem_id', $problem_id)
                    ->where('tag_id', $tag_id)
                    ->first()->decrement('count');
    }
    
    public function addProblemTag($problem_id, $tag_id)
    {
        $this->model->where('problem_id', $problem_id)
                    ->where('tag_id', $tag_id)
                    ->first()->increment('count');
    }
    
    public function getOrCreate(array $values)
    {
        return $this->model->firstOrCreate($values);
    }
    
}

?>