<?php

namespace App\Services\Protects;

use App\Repositories\ProblemRepository,
    App\Repositories\ThankRepository,
    App\Repositories\ProblemThankRepository,
    App\Repositories\ProblemTagRepository;

use App\Models\Thank,
    App\Models\Problem;
    
use Storage;

class ProblemServiceProtected extends BaseServiceProtected
{
    protected $problemRepository;
    protected $thankRepository;
    protected $problemThankRepository;
    protected $problemTagRepository;
    
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
    public function createProblem(array $values)
    {
        $problem = $this->problemRepository->create($values);

        $problemThank = $this->problemThankRepository->create([
            'thank_id' => Thank::authorCode,
            'user_id' => $this->user_id,
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
        return $this->problemRepository
                    ->getOpenProblemsWithStatistics($this->user_id)
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
        return $this->problemRepository
                    ->getProblem($this->user_id, $problem_id)
                    ->firstOrFail();
    }

    /**
     * 문제 Thank 가져오기
     *
     * @param int   $problem_id
     * @return App\Models\ProblemThank with User, Thank
     */    
    public function getProblemThanks($problem_id)
    {
        return $this->problemThankRepository
                    ->getProblemThanks($problem_id)
                    ->get();
    }


    /**
     * 공개되지 않은 문제 목록 가져오기 (관리자용)
     *
     * @return Illuminate\Support\Collection
     */
    public function getHiddenProblems()
    {
        return $this->problemRepository
                    ->getHiddenProblems()
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
        return $this->problemRepository
                    ->getNewestProblems($this->user_id, $takes)
                    ->get();
    }
    
    /**
     * 유저가 만든 문제 목록 가져오기
     *
     * @param int   $user_id
     * @return paginate of problem
     */
    public function getProblemsByAuthor()
    {
        return $this->problemRepository
                    ->getProblemsByAuthor($this->user_id)
                    ->paginate($this->paginateCount);
    }
    
    
    /**
     * 유저가 만든 문제 목록 중 대기중인 문제 가져오기
     *
     * @param int   $user_id
     * @return paginate of problem
     */
    public function getReadyProblemsByAuthor()
    {
        return $this->problemRepository
                    ->getReadyProblemsByAuthor($this->user_id)
                    ->paginate($this->paginateCount);
    }
    
    /**
     * 모든 대기중인 문제 목록 가져오기
     *
     * @param int   $user_id
     * @return paginate of problem
     */
    public function getReadyProblems()
    {
        return $this->problemRepository
                    ->getProblemByStatus(Problem::readyCode)
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
     * 유저가 맞은 문제 목록 가져오기
     *
     * @param int   $user_id
     * @return collection of problem
     */
    public function getAcceptProblemsByUser($user_id)
    {
        return $this->problemRepository
                    ->getAcceptProblemsByUser($user_id)
                    ->get();
    }
    
    /**
     * 유저가 도전중인 문제 목록 가져오기
     *
     * @param int   $user_id
     * @return collection of problem
     */
    public function getTriedProblemsByUser($user_id)
    {
        return $this->problemRepository
                    ->getTriedProblemsByUser($user_id)
                    ->get();
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
    
    
    /**
     * 해당 문제를 압축한 후 압축 파일의 경로를 반환 
     *
     * @param int   $problem_id
     * @return zip file's path of the specified resource
     */
    public function zipData($problem_id)
    {
        $datDirectory = storage_path('app/data');
        $fileName = "{$problem_id}-dataset.zip";
        
        $cmd = "cd {$datDirectory} && mkdir -p zip && zip zip/{$fileName} ".
            $problem_id.'/*.in '. $problem_id .'/*.out';
        shell_exec( $cmd );
        
        $path = $datDirectory .'/zip/'. $problem_id.'-dataset.zip';
        
        return $path;
    }
    
    /**
     * 해당 문제에 대한 데이터가 존재하는 지 확인
     *
     * @param int   $problem_id
     * @return boolean
     */
    public function hasData($problem_id)
    {
        $fileDirectory = "data/{$problem_id}";
        return Storage::has($fileDirectory);
    }
}
