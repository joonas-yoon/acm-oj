<?php

namespace App\Repositories;

use App\Models\ContestParticipant;

class ContestRepository extends BaseRepository
{
    public function __construct(Contest $contest)
    {
        $this->model = $contest;
    }
    

    
}
