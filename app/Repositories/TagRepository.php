<?php

namespace App\Repositories;

use App\Models\Tag,
    App\Models\Problem;

class TagRepository extends BaseRepository
{

    public function __construct(Tag $tag)
    {
        $this->model = $tag;
    }
    
    public function getOrCreate(array $values)
    {
        return $this->model->firstOrCreate($values);
    }
    
    public function getTag($column, $value)
    {
        return $this->model->where($column, $value)->first();
    }
    
    public function getTagsWithProblem()
    {
        return $this->model->withProblemTag(Problem::openCode);
    }
    
    public function getOpenTagsWithProblem()
    {
        return $this->model->withProblemTag(Problem::openCode)
                    ->whereStatus(Tag::openCode);
    }
    
    public function getTagsByUser($user_id, $problem_id)
    {
        return $this->model->hasUserTag($user_id, $problem_id);
    }
}
