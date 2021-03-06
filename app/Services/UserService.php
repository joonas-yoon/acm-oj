<?php

namespace App\Services;

use App\Services\Protects\UserServiceProtected;

use App\Models\User;

class UserService extends BaseService
{
    protected $userRepository;

    public function __construct
    (
        UserServiceProtected $userServiceProtected
    )
    {
        $this->service = $userServiceProtected;
    }
    
    /**
     * 이름이나 이메일로 유저 가져오기
     *
     * @param string $nameOrEmail
     * @return App\Models\User
     */
    public function getUserByNameOrEmail($nameOrEmail)
    {
        return $this->service->getUserByNameOrEmail($nameOrEmail);
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
        $profiles = array_only($profiles, User::$editable);
        return $this->service->updateProfile($profiles);
    }

}