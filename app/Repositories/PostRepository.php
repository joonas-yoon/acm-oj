<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository extends BaseRepository
{
    public function __construct(Post $post)
    {
        $this->model = $post;
    }
    
    public function getPosts()
    {
        return $this->model->list();
    }
    
    public function getWithUser()
    {
        return $this->model->list()
                    ->withUser();
    }
}
