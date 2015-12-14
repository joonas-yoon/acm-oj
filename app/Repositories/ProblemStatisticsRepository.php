<?php

namespace App\Repositories;

use App\Models\ProblemStatistics;

class ProblemStatisticsRepository extends BaseRepository
{

    public function __construct(ProblemStatistics $problemStatistics)
    {
        $this->model = $problemStatistics;
    }
    
    public function getProblemStatistics($problem_id, $result_id)
    {
        return $this->model
                    ->whereProblem($problem_id)
                    ->whereResult($result_id)
                    ->first();
    }
    
}

?>