<?php

namespace App\Repositories;

use App\Models\Problem,
    App\Models\Result;

class ProblemRepository extends BaseRepository
{

    public function __construct(Problem $problem)
    {
        $this->model = $problem;
    }
    
    public function getProblem($user_id, $problem_id)
    {
        return $this->model
                    ->withStatistics($user_id, Result::acceptCode)
                    ->whereProblem($problem_id);
    }
    
    public function getOpenProblems()
    {
        return $this->model->list()
                    ->whereStatus(Problem::openCode);
                    
    }
    
    public function getOpenProblemsWithStatistics($user_id)
    {
        return $this->model->list()
                    ->withStatistics($user_id, Result::acceptCode)
                    ->whereStatus(Problem::openCode);
    }
    
    public function getHiddenProblems()
    {
        return $this->model->list()
                    ->whereStatus(Problem::hiddenCode);
    }
    
    public function getNewestProblems($user_id, $takes)
    {
        return $this->model->list()->latest('created_at')->latest('id')
                    ->withStatistics($user_id, Result::acceptCode)
                    ->whereStatus(Problem::openCode)
                    ->take($takes)->get();
    }
}
?>