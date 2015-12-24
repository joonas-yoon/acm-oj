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
     * 게시글 목록 가져오기
     *
     * @return Illuminate\Support\Collection
     */
    public function getPosts()
    {
        return $this->service->getPosts();
    }
}