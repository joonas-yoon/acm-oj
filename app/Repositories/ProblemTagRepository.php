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
        return $this->model->with('tags')
                    ->where('problem_id', $problem_id)
                    ->orderBy('count', 'desc')
                    ->whereHas('tags', function($query) {
                        $query->where('status', Tag::openCode);
                    })
                    ->setTake($take)
                    ->get();
    }
    
    public function getTagWithProblem($tag_id)
    {
        return $this->model->with('problems', function($query) {
                        $query->select(Problem::$listColumns)
                              ->orderBy('count', 'desc');
                    })
                    ->where('tag_id', $tag_id)
                    ->whereHas('problems', function($query) {
                        $query->where('status', Problem::openCode);
                    });
    }
    
    public function subProblemTag($problem_id, $tag_id)
    {
        $this->model->where('problem_id', $problem_id)
                    ->where('tag_id', $tag_id)
                    ->firstOrFail()->decrement('count');
    }
    
    public function addProblemTag($problem_id, $tag_id)
    {
        $this->model->where('problem_id', $problem_id)
                    ->where('tag_id', $tag_id)
                    ->firstOrFail()->increment('count');
    }
    
    public function getOrCreate(array $values)
    {
        return $this->model->firstOrCreate($values);
    }
    
}

?>