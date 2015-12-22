<?php

namespace App\Repositories;

use App\Models\Statistics,
    App\Models\Problem;

class StatisticsRepository extends BaseRepository
{
    public function __construct(Statistics $statistics)
    {
        $this->model = $statistics;
    }
    
    public function getStatistics($user_id, $problem_id, $result_id)
    {
        return $this->model->whereUser($user_id)
                    ->whereProblem($problem_id)
                    ->whereResult($result_id)
                    ->first();
    }
    
    public function getProblems($user_id, $result_id)
    {
        return $this->model->withProblem()
                    ->whereUser($user_id)
                    ->whereResult($result_id)
                    ->whereCountUp(0)
                    ->hasProblemStatus(Problem::openCode)
                    ->orderBy('problem_id');
    }
    
    public function getProblemsCountZero($user_id, $result_id)
    {
        return $this->model->withProblem()
                    ->whereUser($user_id)
                    ->whereResult($result_id)
                    ->whereCount(0)
                    ->hasProblemStatus(Problem::openCode)
                    ->orderBy('problem_id');
    }
    
    public function getByProblem($problem_id)
    {
        return $this->model->whereProblem($problem_id)
                    ->orderBy('user_id');
    }
    
    public function removeByProblem($problem_id)
    {
        return $this->model->whereProblem($problem_id)
                    ->delete();
    }
}

?>