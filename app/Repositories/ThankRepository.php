<?php

namespace App\Repositories;

use App\Models\Thank;

class ThankRepository extends BaseRepository
{
    public function __construct(Thank $thank)
    {
        $this->model = $thank;
    }
    
}

?>