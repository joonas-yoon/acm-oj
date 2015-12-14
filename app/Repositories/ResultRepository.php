<?php

namespace App\Repositories;

use App\Models\Result;

class ResultRepository extends BaseRepository
{
    public function __construct(Result $result)
    {
        $this->model = $result;
    }
    
    public function getResultWithUserStatistics($user_id)
    {
        return $this->model
                    ->withUserStatistics($user_id)
                    ->whereResultUp(Result::runningCode)
                    ->wherePublished(true);
    }
}

?>