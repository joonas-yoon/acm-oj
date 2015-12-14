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
    
    public function getTag($column, $value)
    {
        return $this->model->where($column, $value)->first();
    }
    
    public function getOpenTagsWithProblem()
    {
        return $this->model->withProblemTag(Problem::openCode)
                    ->whereStatus(Tag::openCode);
    }
}
