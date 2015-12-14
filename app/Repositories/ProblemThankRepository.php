<?php

namespace App\Repositories;

use App\Models\ProblemThank,
    App\Models\Problem,
    App\Models\Thank;

class ProblemThankRepository extends BaseRepository
{
    public function __construct(ProblemThank $problemThank)
    {
        $this->model = $problemThank;
    }
    
    
    public function getAuthorWithProblem($user_id)
    {
        return $this->model->withProblem()
                    ->whereUser($user_id)
                    ->whereThank(Thank::authorCode);
    }
    
    public function getAuthorWithReadyProblem($user_id)
    {
        return $this->model->withProblem()
                    ->whereUser($user_id)
                    ->whereThank(Thank::authorCode)
                    ->inProblemStatus([Problem::hiddenCode, Problem::readyCode]);
    }
    
    public function getUser($problem_id, $thank_id)
    {
        return $this->model->whereProblem($problem_id)
                    ->whereThank($thank_id)
                    ->firstOrFail()->user_id;
    }
}

?>