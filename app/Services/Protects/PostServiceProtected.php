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
    
    public function getPosts()
    {
        return $this->postRepository
                    ->getWithUser()
                    ->paginate($this->paginateCount);
    }
}
