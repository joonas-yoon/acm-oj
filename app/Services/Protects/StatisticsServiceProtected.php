<?php

namespace App\Services\Protects;

use App\Repositories\ResultRepository,
    App\Repositories\StatisticsRepository,
    App\Repositories\UserStatisticsRepository,
    App\Repositories\ProblemStatisticsRepository,
    App\Repositories\ProblemRepository,
    App\Repositories\UserRepository;

use App\Models\Result;

class StatisticsServiceProtected extends BaseServiceProtected
{
    protected $statisticsRepository;
    protected $userStatisticsRepository;
    protected $problemStatisticsRepository;
    protected $problemRepository;
    protected $userRepository;
    protected $resultRepository;
    
    public function __construct
    (
        StatisticsRepository $statisticsRepository,
        UserStatisticsRepository $userStatisticsRepository,
        ProblemStatisticsRepository $problemStatisticsRepository,
        ProblemRepository $problemRepository,
        UserRepository $userRepository,
        ResultRepository $resultRepository
    )
    {
        $this->statisticsRepository = $statisticsRepository;
        $this->userStatisticsRepository = $userStatisticsRepository;
        $this->problemStatisticsRepository = $problemStatisticsRepository;
        $this->problemRepository = $problemRepository;
        $this->userRepository = $userRepository;
        $this->resultRepository = $resultRepository;
    }
    
    
    /**
     * 정답률 구하기
     *
     * @param int   $acceptCount
     * @param int   $submitCount
     * @return double
     */
    public function getRate($acceptCount, $submitCount)
    {
        if($submitCount)
            return 100 * $acceptCount / ($submitCount);
        return 0;
    }
    
    /**
     * 통계 카운트 가져오기. 데이터가 없으면 0 반환
     *
     * @param App\Models:hasCount   $statistics
     * @return int
     */ 
    public function getCountOrZero($statistics) {
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
     * @return int
     */
    public function isAcceptedProblem($user_id, $problem_id)
    {
        $stat = $this->statisticsRepository
                     ->getStatistics($user_id, $problem_id, Result::acceptCode);
        if($stat)
            return $stat->count;
        return -1;
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
    public function addSubmit($problem_id)
    {
        $this->statisticsRepository->firstOrCreate([
            'user_id' => $this->user_id,
            'problem_id' => $problem_id,
            'result_id' => Result::acceptCode
        ]);
        
        $this->userRepository->get($this->user_id)->increment('total_submit');
        $this->problemRepository->get($problem_id)->increment('total_submit');
    }

    /**
     * 유저의 결과 카운트 가져오기
     *
     * @param int   $user_id
     * @param int   $result_id
     * @return int
     */
    public function getResultCountByUser($user_id, $result_id)
    {
        return $this->getCountOrZero($this->userStatisticsRepository
                    ->getCount($user_id, $result_id));
    }

    /**
     * 유저의 모든 결과 카운트 가져오기
     *
     * @param int   $user_id
     * @return collction of result with statistiscs
     */
    public function getAllResultCountByUser($user_id)
    {
        return $this->resultRepository
                    ->getResultWithUserStatistics($user_id)
                    ->get();
    }


    /**
     * 채점결과 추가하기
     *
     * @param int   $user_id
     * @param int   $problem_id
     * @param int   $result_id
     * @return void
     */
    public function addResult($user_id, $problem_id, $result_id)
    {
        $statistics = $this->statisticsRepository->firstOrCreate([
            'user_id' => $user_id,
            'problem_id' => $problem_id,
            'result_id' => $result_id
        ]);
        
        $statistics->increment('count');
        
        $problemStatistics = $this->problemStatisticsRepository->firstOrCreate([
            'problem_id' => $problem_id,
            'result_id' => $result_id
        ]);
        
        $problemStatistics->increment('count');
        
        $userStatistics = $this->userStatisticsRepository->firstOrCreate([
            'user_id' => $user_id,
            'result_id' => $result_id
        ]);
        
        $userStatistics->increment('count');
        
        if($result_id == Result::acceptCode && $statistics->count == 1)
        {
            $user = $this->userRepository->get($user_id);
            $user->increment('total_clear');
        }
    }

    /**
     * 해당 문제에 관련된 통계 지우기 (관리자 용)
     * 
     * @param int   $problem_id
     * @return void
     */
    public function removeStatistics($problem_id)
    {
        $this->problemRepository
             ->update($problem_id, ['total_clear' => 0, 'total_submit' => 0]);
        $this->problemStatisticsRepository
             ->remove($problem_id);
        
        $statisticses = $this->statisticsRepository
                             ->getByProblem($problem_id)
                             ->get();
        
        $currentUser = 0;
        $submitCount = 0;
        $accept = 0;
        foreach($statisticses as $statistics)
        {
            if($statistics->user_id != $currentUser)
            {
                if($currentUser != 0 && $submitCount > 0)
                    $this->userRepository->subSubmit($currentUser, $submitCount, $accept);

                $currentUser = $statistics->user_id;
                $submitCount = 0;
                $accept = 0;
            }
            $submitCount += $statistics->count;
            
            if($statistics->count > 0)
                $this->userStatisticsRepository
                     ->subCount($statistics->user_id, $statistics->result_id, $statistics->count);
            if($statistics->result_id == Result::acceptCode && $statistics->count > 0)
                $accept = 1;
        }
        if($currentUser != 0 && $submitCount > 0)
            $this->userRepository->subSubmit($currentUser, $submitCount, $accept);
        
        $this->statisticsRepository
             ->removeByProblem($problem_id);
    }

}
