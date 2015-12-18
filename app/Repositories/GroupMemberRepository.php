<?php

namespace App\Repositories;

use App\Models\GroupMember;

class GroupMemberRepository extends BaseRepository
{
    public function __construct(GroupMember $groupMember)
    {
        $this->model = $groupMember;
    }
    
    public function getGroupMembers($group_id)
    {
        return $this->model->withUser()
                    ->whereGroup($group_id);
    }
    
}
