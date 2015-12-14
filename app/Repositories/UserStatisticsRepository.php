<?php

namespace App\Repositories;

use App\Models\UserStatistics;

class UserStatisticsRepository extends BaseRepository
{

    public function __construct(UserStatistics $userStatistics)
    {
        $this->model = $userStatistics;
    }
    
    public function getCount($user_id, $result_id)
    {
        return $this->model->whereUser($user_id)
                    ->whereResult($result_id)
                    ->first();
    }
    
}

?>