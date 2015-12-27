<?php

namespace App\Services;

use App\Services\Protects\ProblemServiceProtected;

use App\Models\Problem;

class ProblemService extends BaseService
{
    public function __construct
    (
        ProblemServiceProtected $problemServiceProtected
    )
    {
        $this->service = $problemServiceProtected;
    }
    
    
    /**
     * 문제 만들기
     *
     * @param array $values
     * @return App\Models\Problem
     */
    public function createProblem(array $values)
    {
        $values = array_only($values, Problem::$editable);
        return $this->service->createProblem($values);
    }
    
    /**
     * 공개된 문제 목록 가져오기
     *
     * @return Illuminate\Support\Collection
     */
    public function getOpenProblems()
    {
        return $this->service->getOpenProblems();
    }

    /**
     * 문제 가져오기
     *
     * @param int   $problem_id
     * @return App\Models\Problem
     */    
    public function getProblem($problem_id)
    {
        return $this->service->getProblem($problem_id);
    }

    /**
     * 문제 Thank 가져오기
     *
     * @param int   $problem_id
     * @return App\Models\ProblemThank with User, Thank
     */    
    public function getProblemThanks($problem_id)
    {
        return $this->service->getProblemThanks($problem_id);
    }

    /**
     * 공개되지 않은 문제 목록 가져오기 (관리자용)
     *
     * @return Illuminate\Support\Collection
     */
    public function getHiddenProblems()
    {
        return $this->service->getHiddenProblems();
    }

    /**
     * 최근에 만들어진 문제 가져오기
     *
     * @param int   $takes
     * @return Illuminate\Support\Collection
     */
    public function getNewestProblems($takes)
    {
        return $this->service->getNewestProblems($takes);
    }
    
    /**
     * 유저가 만든 문제 목록 가져오기
     *
     * @return paginate of problem
     */
    public function getProblemsByAuthor()
    {
        return $this->service->getProblemsByAuthor();
    }
    
    
    /**
     * 유저가 만든 문제 목록 중 대기중인 문제 가져오기
     *
     * @return paginate of problem
     */
    public function getReadyProblemsByAuthor()
    {
        return $this->service->getReadyProblemsByAuthor();
    }
    
    public function getReadyProblems()
    {
        if( ! is_admin($this->user_id) )
            return false;
        
        return $this->service->getReadyProblems();
    }
    
    /**
     * 해당 문제의 제작자 가져오기
     *
     * @param int   $problem_id
     * @return int
     */
    public function getAuthorOfProblem($problem_id)
    {
        return $this->service->getAuthorOfProblem($problem_id);
    }
    
    /**
     * 유저가 맞은 문제 목록 가져오기
     *
     * @param int   $user_id
     * @return collection of problem
     */
    public function getAcceptProblemsByUser($user_id)
    {
        return $this->service->getAcceptProblemsByUser($user_id);
    }
    
    /**
     * 유저가 도전중인 문제 목록 가져오기
     *
     * @param int   $user_id
     * @return collection of problem
     */
    public function getTriedProblemsByUser($user_id)
    {
        return $this->service->getTriedProblemsByUser($user_id);
    }
    
    
    /**
     * 해당 문제의 상태 바꾸기
     *
     * @param int   $problem_id
     * @param int   $statis
     * @return boolean
     */
    public function updateProblemStatus($problem_id, $status)
    {
        return $this->service->updateProblemStatus($problem_id, $status);
    }
    
    
    /**
     * 해당 문제 업데이트
     *
     * @param int   $problem_id
     * @param array $values
     * @return boolean
     */
    public function updateProblem($problem_id, array $values)
    {
        $values = array_only($values, Problem::$editable);
        return $this->service->updateProblem($problem_id, $values);
    }
    
    /**
     * 해당 문제를 압축한 후 압축 파일의 경로를 반환 
     *
     * @param int   $problem_id
     * @return zip file's path of the specified resource
     */
    public function zipData($problem_id)
    {
        if( ! $this->hasData($problem_id) )
            return abort(404);
            
        return $this->service->zipData($problem_id);
    }
    
    /**
     * 해당 문제에 대한 데이터가 존재하는 지 확인
     *
     * @param int   $problem_id
     * @return boolean
     */
    public function hasData($problem_id)
    {
        if( is_admin() )
            return $this->service->hasData($problem_id);
        else if( $this->user_id == $this->getAuthorOfProblem($problem_id) )
            return $this->service->hasData($problem_id);
        return false;
    }
}
