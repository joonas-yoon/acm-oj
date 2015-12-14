<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{

    public function __construct(User $user)
    {
        $this->model = $user;
    }
    
    public function getUserByNameOrEmail($nameOrEmail)
    {
        return $this->model->whereNameOrEmail($nameOrEmail)
                    ->firstOrFail();
    }

}
?>