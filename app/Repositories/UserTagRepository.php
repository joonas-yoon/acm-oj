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
        return $this->model->whereUser($user_id)
                    ->whereProblem($problem_id)
                    ->get();
    }
    
}

?>