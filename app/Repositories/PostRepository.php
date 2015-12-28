<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository extends BaseRepository
{
    public function __construct(Post $post)
    {
        $this->model = $post;
    }
    
    public function getPost($id)
    {
        return $this->model->list()
                    ->onPost()
                    ->find($id);
    }
    
    public function getPosts($parent_on)
    {
        return $this->model->list()
                    ->onPost($parent_on)
                    ->withUser();
    }
    
    public function getComments($parent_id, $parent_on)
    {
        return $this->model->list()
                    ->commentsOf($parent_id, $parent_on)->withUser();
    }
    
    public function getLatestSubmit($user_id = null)
    {
        if( ! $user_id ){
            return $this->model
                        ->orderBy('id', 'desc')
                        ->first();
        }
        
        return $this->model->orderBy('id', 'desc')
                    ->where('user_id', $user_id)
                    ->first();
    }
}
