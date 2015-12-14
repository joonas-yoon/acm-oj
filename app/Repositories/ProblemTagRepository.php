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
        return $this->model->withTag()
                    ->whereProblem($problem_id)
                    ->whereCountUp(0)
                    ->hasTagStatus(Tag::openCode)
                    ->orderByCount('desc')
                    ->setTake($take)
                    ->get();
    }
    
    public function getTagWithProblem($user_id, $tag_id)
    {
        return $this->model->withProblem($user_id)
                    ->whereTag($tag_id)
                    ->whereCountUp(0)
                    ->hasProblemStatus(Problem::openCode)
                    ->orderByCount('desc');
    }
    
    public function subProblemTag($problem_id, $tag_id)
    {
        $this->model->whereProblem($problem_id)
                    ->whereTag($tag_id)
                    ->firstOrFail()->subTag();
    }
    
    public function addProblemTag($problem_id, $tag_id)
    {
        $this->model->whereProblem($problem_id)
                    ->whereTag($tag_id)
                    ->firstOrFail()->addTag();
    }
    
    public function getOrCreate(array $values)
    {
        return $this->model->firstOrCreate($values);
    }
    
}

?>