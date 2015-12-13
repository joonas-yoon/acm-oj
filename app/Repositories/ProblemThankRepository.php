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
        return $this->model->with(['problems' => function($query) {
                        $query->select(Problem::$listColumns);
                    }])
                    ->where('user_id', $user_id)
                    ->where('thank_id', Thank::authorCode);
    }
    
    public function getAuthorWithReadyProblem($user_id)
    {
        return $this->model->with(['problems' => function($query) {
                        $query->select(Problem::$listColumns);
                    }])
                    ->where('user_id', $user_id)
                    ->where('thank_id', Thank::authorCode)
                    ->whereHas('problems', function ($query) {
                        $query->whereIn('status', [Problem::hiddenCode, Problem::readyCode]);
                    });
    }
    
    public function getUser($problem_id, $thank_id)
    {
        return $this->model->where('problem_id', $problem_id)
                    ->where('thank_id', $thank_id)
                    ->firstOrFail()->user_id;
    }
}

?>