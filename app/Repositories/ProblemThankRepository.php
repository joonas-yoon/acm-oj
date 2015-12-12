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
    
    
    public function getAuthorsWithProblem($user_id, $paginateCount)
    {
        return $this->model->with(['problems' => function($query) {
                        $query->select(Problem::$listColumns);
                    }])
                    ->where('user_id', $user_id)
                    ->where('thank_id', Thank::authorCode)
                    ->paginate($paginateCount);
    }
    
    public function getUser($problem_id, $thank_id)
    {
        return $this->model->where('problem_id', $problem_id)
                    ->where('thank_id', $thank_id)
                    ->firstOrFail()->user_id;
    }
}

?>