<?php

namespace App\Repositories;

use App\Models\Code;

class CodeRepository extends BaseRepository
{
    public function __construct(Code $code)
    {
        $this->model = $code;
    }
    
}

?>