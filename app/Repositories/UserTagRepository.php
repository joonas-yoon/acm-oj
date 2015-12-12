<?php

namespace App\Repositories;

use App\Models\UserTag;

class UserTagRepository extends BaseRepository
{

    public function __construct(UserTag $userTag)
    {
        $this->model = $userTag;
    }
    
    public function getUserTagsByProblem($user_id, $problem_id)
    {
        return $this->model->where('user_id', $user_id)
                    ->where('problem_id', $problem_id)
                    ->get();
    }
    
}

?>