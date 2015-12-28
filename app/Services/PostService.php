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
     * 게시글 수정
     *
     * @param array $values
     * @return App\Models\Post
     */
    public function updatePost($post_id, array $values)
    {
        $values = array_only($values, Post::$editable);
        return $this->service->updatePost($post_id, $values);
    }
    
    /**
     * 게시글 삭제
     *
     * @param array $values
     * @return boolean
     */
    public function deletePost($post_id)
    {
        return $this->service->deletePost($post_id);
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
    public function getPosts($parent_on = 'post')
    {
        return $this->service->getPosts($parent_on);
    }
    
    /**
     * 해당 게시글의 댓글 목록 가져오기
     *
     * @return Illuminate\Support\Collection
     */
    public function getComments($parent_id, $parent_on = 'post')
    {
        return $this->service->getComments($parent_id, $parent_on);
    }
    
    /**
     * 모든 (또는 특정) 유저의 가장 최근에 제출된 항목을 가져오기
     *
     * @return Illuminate\Support\Collection
     */
    public function getLastestSubmit($user_id = null)
    {
        return $this->service->getLastestSubmit($user_id);
    }
}