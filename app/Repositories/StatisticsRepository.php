<?php

namespace App\Repositories;

use App\Models\Statistics;

class StatisticsRepository extends BaseRepository
{
    public function __construct(Statistics $statistics)
    {
        $this->model = $statistics;
    }
    
    public function getStatistics($user_id, $problem_id, $result_id)
    {
        return $this->model->where('user_id', $user_id)
                    ->where('problem_id', $problem_id)
                    ->where('result_id', $result_id)
                    ->first();
    }
    
    
}

?>