<?php

namespace App\Services;

use App\Services\Protects\PostServiceProtected;

use App\Models\Post;

class PostService extends BaseService
{
    protected $postRepository;

    public function __construct
    (
        PostServiceProtected $postServiceProtected
    )
    {
        $this->service = $postServiceProtected;
    }
    
    /**
     * 게시글 생성
     *
     * @param array $values
     * @return App\Models\Post
     */
    public function createPost(array $values)
    {
        $values = array_only($values, Post::$editable);
        return $this->service->createPost($values);
    }
    public function createComment(array $values)
    {
        if( ! array_has($values, 'parent_id') )
            return abort(404);
        $values = array_only($values, Post::$editable);
        return $this->service->createComment($values);
    }
    
    /**
     * 하나의 게시글 가져오기
     *
     * @return Illuminate\Support\Collection
     */
    public function getPost($id)
    {
        $post = $this->service->getPost($id);
        if( ! $post )
            return abort(404);
            
        return $post;
    }
    
    
    /**
     * 게시글 목록 가져오기
     *
     * @return Illuminate\Support\Collection
     */
    public function getPosts()
    {
        return $this->service->getPosts();
    }
    
    /**
     * 해당 게시글의 댓글 목록 가져오기
     *
     * @return Illuminate\Support\Collection
     */
    public function getComments($parent_id)
    {
        return $this->service->getComments($parent_id);
    }
}