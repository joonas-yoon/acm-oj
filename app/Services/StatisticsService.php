<?php

namespace App\Services;

use App\Services\Protects\StatisticsServiceProtected;

class StatisticsService extends BaseService
{
    public function __construct
    (
        StatisticsServiceProtected $statisticsServiceProtected
    )
    {
        $this->service = $statisticsServiceProtected;
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
        return $this->service->getRate($acceptCount, $submitCount);
    }
    
    /**
     * 통계 카운트 가져오기. 데이터가 없으면 0 반환
     *
     * @param App\Models:hasCount   $statistics
     * @return int
     */ 
    public function getCountOrZero($statistics) {
        return $this->service->getCountOrZero($statistics);
    }
    
    /**
     * 해당 문제의 맞았습니다 수 가져오기
     *
     * @param int   $problem_id
     * @return int
     */
    public function getAcceptCountOfProblem($problem_id)
    {
        return $this->service->getAcceptCountOfProblem($problem_id);
    }

    /**
     * 해당 문제의 제출 수 가져오기
     *
     * @param int   $problem_id
     * @return int
     */
    public function getSubmitCountOfProblem($problem_id)
    {
        return $this->service->getSubmitCountOfProblem($problem_id);
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
        return $this->service->isAcceptedProblem($user_id, $problem_id);
    }

    /**
     * 해당 유저가 해당 문제를 도전중인지 여부 알아내기
     *
     * @param int   $user_id
     * @param int   $problem_id
     * @return boolean
     */
    public function isTriedProblem($user_id, $problem_id)
    {
        return $this->service->isTriedProblem($user_id, $problem_id);
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
        return $this->service->addSubmit($problem_id);
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
        return $this->service->getResultCountByUser($user_id, $result_id);
    }

    /**
     * 유저의 모든 결과 카운트 가져오기
     *
     * @param int   $user_id
     * @return collction of result with statistiscs
     */
    public function getAllResultCountByUser($user_id)
    {
        return $this->service->getAllResultCountByUser($user_id);
    }


}
