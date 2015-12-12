<?php

namespace App\Services;

use App\Repositories\ResultRepository,
    App\Repositories\StatisticsRepository,
    App\Repositories\UserStatisticsRepository,
    App\Repositories\ProblemStatisticsRepository,
    App\Repositories\ProblemRepository,
    App\Repositories\UserRepository;

use App\Models\Result;

use Sentinel;

class StatisticsService
{
    protected $statisticsRepository;
    protected $userStatisticsRepository;
    protected $problemStatisticsRepository;
    protected $problemRepository;
    protected $userRepository;
    
    public function __construct
    (
        StatisticsRepository $statisticsRepository,
        UserStatisticsRepository $userStatisticsRepository,
        ProblemStatisticsRepository $problemStatisticsRepository,
        ProblemRepository $problemRepository,
        UserRepository $userRepository
    )
    {
        $this->statisticsRepository = $statisticsRepository;
        $this->userStatisticsRepository = $userStatisticsRepository;
        $this->problemStatisticsRepository = $problemStatisticsRepository;
        $this->problemRepository = $problemRepository;
        $this->userRepository = $userRepository;
    }
    
    
    /**
     * 정답률 구하기
     *
     * @param int   $acceptCount
     * @param int   $submitCount
     * @return double
     */
    static public function getRate($acceptCount, $submitCount)
    {
        if($submitCount)
            return 100 * $acceptCount / ($acceptCount + $submitCount);
        return 0;
    }
    
    /**
     * 통계 카운트 가져오기. 데이터가 없으면 0 반환
     *
     * @param App\Models:hasCount   $statistics
     * @return int
     */ 
    static protected function getCountOrZero($statistics) {
        if( isset($statistics) )
            return $statistics->count;
        return 0;
    }
    
    /**
     * 해당 문제의 맞았습니다 수 가져오기
     *
     * @param int   $problem_id
     * @return int
     */
    public function getAcceptCountOfProblem($problem_id)
    {
        return $this->getCountOrZero($this->problemStatisticsRepository
            ->getProblemStatistics($problem_id, Result::acceptCode));
    }

    /**
     * 해당 문제의 제출 수 가져오기
     *
     * @param int   $problem_id
     * @return int
     */
    public function getSubmitCountOfProblem($problem_id)
    {
        return $this->problemRepository
            ->get($problem_id)->total_submit;
    }
    
    /**
     * 해당 유저가 해당 문제를 맞았는지 여부 알아내기
     *
     * @param int   $user_id
     * @param int   $problem_id
     * @return boolean
     */
    public function isAcceptedProblem($user_id, $problem_id)
    {
        return $this->getCountOrZero($this->statisticsRepository
            ->getStatistics($user_id, $problem_id, Result::acceptCode)) > 0;
    }

    /**
     * 해당 유저가 해당 문제를 도전중인지 여부 알아내기
     *
     * @param int   $user_id
     * @param int   $problem_id
     * @return boolean
     */
    public function isTriedProblem($user_id, $problem_id) {
        $accept = $this->statisticsRepository
            ->getStatistics($user_id, $problem_id, Result::acceptCode);
        if($accept)
            return $accept->count == 0;
        return false;
    }
    
    /**
     * 제출시 통계 업데이트
     *
     * @param int   $user_id
     * @param int   $problem_id
     * @return boolean
     */
    public function addSubmit($user_id, $problem_id)
    {
        $this->statisticsRepository->firstOrCreate([
            'user_id' => $user_id,
            'problem_id' => $problem_id,
            'result_id' => Result::acceptCode
        ]);
        
        $this->userRepository->get($user_id)->increment('total_submit');
        $this->problemRepository->get($problem_id)->increment('total_submit');
    }
    
}


?>