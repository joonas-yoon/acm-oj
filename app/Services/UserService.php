<?php

namespace App\Services;

use App\Repositories\SolutionRepository,
    App\Repositories\UserRepository,
    App\Repositories\CodeRepository,
    App\Repositories\StatisticsRepository,
    App\Repositories\ResultRepository;
    
use App\Services\StatisticsService;

use App\Models\Result,
    App\Models\User;

use DB;

class UserService extends BaseService
{
    protected $solutionRepository;
    protected $userRepository;
    protected $codeRepository;
    protected $statisticsRepository;
    protected $resultRepository;
    
    protected $statisticsService;
    

    public function __construct
    (
        SolutionRepository $solutionRepository,
        UserRepository $userRepository,
        CodeRepository $codeRepository,
        ResultRepository $resultRepository,
        StatisticsService $statisticsService
    )
    {
        $this->solutionRepository = $solutionRepository;
        $this->userRepository = $userRepository;
        $this->codeRepository = $codeRepository;
        $this->resultRepository = $resultRepository;
        
        $this->statisticsService = $statisticsService;
        
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
        $profiles = array_only($profiles, User::$editable);
        return $this->userRepository->update($this->user_id, $profiles);
    }

}