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
        return $this->problemRepository->getOpenProblems($this->paginateCount);
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
        return $this->problemRepository->getHiddenProblems($this->paginateCount);
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
    public function getAuthorsWithProblem($user_id)
    {
        return $this->problemThankRepository
                    ->getAuthorsWithProblem($user_id, $this->paginateCount);
    }
    
    /**
     * 해당 태그를 가지고 있는 문제 목록을 카운트 순으로 가져오기
     *
     * @param int   $tag_id
     * @return array of App\Models\Problem
     */
    public function getProblemsByTag($tag_id)
    {
        $tagIds = $this->problemTagRepository
                       ->getTagWithProblem($tag_id, $this->paginateCount);
        
        $problems = [];
        foreach($tagIds as $tag)
            array_push($problems, $tag->problems);
        
        return $problems;
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
        return $this->problemRepository->update($problem_id, $values);
    }
}


?>