<?php

namespace App\Services\Protects;

use App\Repositories\PostRepository,
    App\Repositories\UserRepository,
    App\Repositories\ProblemRepository;

use App\Models\Post,
    App\Models\User,
    App\Models\Problem;

class PostServiceProtected extends BaseServiceProtected
{
    protected $postRepository;
    protected $userRepository;
    protected $problemRepository;
    
    public function __construct
    (
        PostRepository $postRepository,
        UserRepository $userRepository,
        ProblemRepository $problemRepository
    )
    {
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
        $this->problemRepository = $problemRepository;
    }
    
    public function createPost(array $values)
    {   
        if( ! array_has($values, 'user_id') )
            array_set($values, 'user_id', $this->user_id);
            
        if( ! array_has($values, 'parent_on') )
            array_set($values, 'parent_on', 'post');
            
        return $this->postRepository->create($values);
    }
    
    public function createComment(array $values)
    {
        if( ! array_has($values, 'user_id') )
            array_set($values, 'user_id', $this->user_id);
            
        if( ! array_has($values, 'parent_on') )
            array_set($values, 'parent_on', 'post');
            
        $id  = array_get($values, 'id');
        $pid = array_get($values, 'parent_id');
            
        $values = array_set($values, 'is_comment', true);
        $values = array_set($values, 'title', $pid.'의 댓글 #'.$id);
        
        return $this->postRepository->create($values);
    }
    
    public function updatePost($post_id, array $values)
    {
        return $this->postRepository->update($post_id, $values);
    }
    
    public function deletePost($post_id)
    {
        return $this->postRepository->delete($post_id);
    }
    
    public function getPost($id)
    {
        return $this->postRepository->getPost($id);
    }
    
    public function getPosts($parent_on)
    {
        return $this->postRepository
                    ->getPosts($parent_on)
                    ->paginate($this->paginateCount);
    }
    
    public function getComments($parent_id, $parent_on)
    {
        return $this->postRepository
                    ->getComments($parent_id, $parent_on);
    }
    
    public function getLatestSubmit($user_id)
    {
        return $this->postRepository
                    ->getLatestSubmit($user_id);
    }
}
