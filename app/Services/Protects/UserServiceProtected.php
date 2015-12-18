<?php

namespace App\Services\Protects;

use App\Repositories\UserRepository;

use App\Models\User;

class UserServiceProtected extends BaseServiceProtected
{
    protected $userRepository;

    public function __construct
    (
        UserRepository $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }
    
    /**
     * 이름이나 이메일로 유저 가져오기
     *
     * @param string $nameOrEmail
     * @return App\Models\User
     */
    public function getUserByNameOrEmail($nameOrEmail)
    {
        return $this->userRepository->getUserByNameOrEmail($nameOrEmail);
    }
    
    
    /**
     * 프로필 업데이트
     *
     * @param int   $user_id
     * @param array $profiles
     * @return boolean
     */
    public function updateProfile(array $profiles)
    {
        return $this->userRepository->update($this->user_id, $profiles);
    }

}