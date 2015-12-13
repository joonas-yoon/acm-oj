<?php

namespace App\Repositories;

use App\Models\Problem;

class ProblemRepository extends BaseRepository
{

    public function __construct(Problem $problem)
    {
        $this->model = $problem;
    }
    
    public function getOpenProblems()
    {
        return $this->model->where('status', Problem::openCode)
                    ->select(Problem::$listColumns);
    }
    
    public function getHiddenProblems()
    {
        return $this->model->where('status', Problem::hiddenCode)
                    ->select(Problem::$listColumns);
    }
    
    public function getNewestProblems($takes)
    {
        return $this->model->latest('created_at')->latest('id')
                    ->where('status', Problem::openCode)
                    ->take($takes)->get(Problem::$listColumns);
    }
}
?>