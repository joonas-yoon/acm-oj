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
        return $this->model->where('user_id', $user_id)
                    ->where('problem_id', $problem_id)
                    ->where('result_id', $result_id)
                    ->first();
    }
    
    public function getProblems($user_id, $result_id)
    {
        return $this->model->with(['problems' => function($query) {
                        $query->select('id', 'title');
                    }])
                    ->where('user_id', $user_id)
                    ->where('result_id', $result_id)
                    ->where('count', '>', 0)
                    ->whereHas('problems', function($query) {
                        $query->where('status', Problem::openCode);
                    })
                    ->orderBy('problem_id')
                    ->get();
    }
    
    public function getProblemsCountZero($user_id, $result_id)
    {
        return $this->model->with(['problems' => function($query) {
                        $query->select('id', 'title');
                    }])
                    ->where('user_id', $user_id)
                    ->where('result_id', $result_id)
                    ->where('count', 0)
                    ->whereHas('problems', function($query) {
                        $query->where('status', Problem::openCode);
                    })
                    ->orderBy('problem_id')
                    ->get();
    }
}

?>