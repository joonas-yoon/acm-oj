<?php

namespace App\Repositories;

use App\Models\User;
use DB;

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

    public function subSubmit($user_id, $submitCount, $accept)
    {
        return $this->model
                    ->whereUser($user_id)
                    ->update([
                        'total_submit' => DB::raw('total_submit - '.$submitCount),
                        'total_clear' => DB::raw('total_clear - '.$accept)
                    ]);
    }

}
?>