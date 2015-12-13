<?php

namespace App\Repositories;

use App\Models\Tag;

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
}
?>