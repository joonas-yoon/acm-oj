<?php

namespace App\Repositories;

use App\Models\UserStatistics;

class UserStatisticsRepository extends BaseRepository
{

    public function __construct(UserStatistics $userStatistics)
    {
        $this->model = $userStatistics;
    }
    
    
    
}

?>