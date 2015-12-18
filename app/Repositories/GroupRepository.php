<?php

namespace App\Repositories;

use App\Models\Group;

class GroupRepository extends BaseRepository
{
    public function __construct(Group $group)
    {
        $this->model = $group;
    }
    
    public function getGroupByUser($user_id)
    {
        return $this->model->withUser()
                    ->hasUser($user_id);
    }
    
    
    
}
