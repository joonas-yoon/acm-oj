<?php

namespace App\Services;

use App\Repositories\ProblemRepository,
    App\Repositories\ThankRepository,
    App\Repositories\ProblemThankRepository,
    App\Repositories\ProblemTagRepository;

use App\Models\Thank,
    App\Models\Problem;

class ProblemService
{
    protected $problemRepository;
    protected $thankRepository;
    protected $problemThankRepository;
    protected $problemTagRepository;
    
    public $paginateCount = 20;
    
    public function __construct
    (
        ProblemRepository $problemRepository,
        ThankRepository $thankRepository,
        ProblemThankRepository $problemThankRepository,
        ProblemTagRepository $problemTagRepository
    )
    {
        $this->problemRepository = $problemRepository;
        $this->thankRepository = $thankRepository;
        $this->problemThankRepository = $problemThankRepository;
        $this->problemTagRepository = $problemTagRepository;
    }
    
    
    /**
     * 문제 만들기
     *
     * @param array $values
     * @param int   $user_id
     * @return App\Models\Problem
     */
    public function createProblem(array $values, $user_id)
    {
        $values = array_only($values, Problem::$editable);
        
        $problem = $this->problemRepository->create($values);

        $problemThank = $this->problemThankRepository->create([
            'thank_id' => Thank::authorCode,
            'user_id' => $user_id,
            'problem_id' => $problem->id
        ]);
        return $problem;
    }
    
    /**
     * 공개된 문제 목록 가져오기
     *
     * @return Illuminate\Support\Collection
     */
    public function getOpenProblems()
    {
        return $this->problemRepository->getOpenProblems()
                    ->paginate($this->paginateCount);
    }

    /**
     * 문제 가져오기
     *
     * @param int   $problem_id
     * @param int   $status
     * @return App\Models\Problem
     */    
    public function getProblem($problem_id)
    {
        return $this->problemRepository->get($problem_id);
    }

    /**
     * 공개되지 않은 문제 목록 가져오기 (관리자용)
     *
     * @return Illuminate\Support\Collection
     */
    public function getHiddenProblems()
    {
        return $this->problemRepository->getHiddenProblems()
                    ->paginate($this->paginateCount);
    }

    /**
     * 최근에 만들어진 문제 가져오기
     *
     * @param int   $takes
     * @return Illuminate\Support\Collection
     */
    public function getNewestProblems($takes)
    {
        return $this->problemRepository->getNewestProblems($takes);
    }
    
    /**
     * 유저가 만든 문제 목록 가져오기
     *
     * @param int   $user_id
     * @return paginate of author
     */
    public function getAuthorWithProblem($user_id)
    {
        return $this->problemThankRepository
                    ->getAuthorWithProblem($user_id)
                    ->paginate($paginateCount);
    }
    
    
    /**
     * 유저가 만든 문제 목록 중 대기중인 문제 가져오기
     *
     * @param int   $user_id
     * @return paginate of author
     */
    public function getAuthorWithReadyProblem($user_id)
    {
        return $this->problemThankRepository
                    ->getAuthorWithReadyProblem($user_id)
                    ->paginate($this->paginateCount);
    }
    
    /**
     * 해당 문제의 제작자 가져오기
     *
     * @param int   $problem_id
     * @return int
     */
    public function getAuthorOfProblem($problem_id)
    {
        return $this->problemThankRepository
                    ->getUser($problem_id, Thank::authorCode);
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
        return $this->problemRepository->update($problem_id, ['status'=>$status]);
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
        return $this->problemRepository->update($problem_id, $values);
    }
}


?>