<?php

namespace App\Repositories;

use App\Models\Contest;

class ContestRepository extends BaseRepository
{
    public function __construct(Contest $contest)
    {
        $this->model = $contest;
    }
    

    
}
