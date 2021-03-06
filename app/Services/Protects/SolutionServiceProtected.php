<?php

namespace App\Services\Protects;

use App\Repositories\SolutionRepository,
    App\Repositories\UserRepository,
    App\Repositories\CodeRepository,
    App\Repositories\StatisticsRepository,
    App\Repositories\ResultRepository;
    
use App\Services\StatisticsService;

use App\Models\Result,
    App\Models\Solution,
    App\Models\Problem;

use DB;

class SolutionServiceProtected extends BaseServiceProtected
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
    
    public function setUser($user)
    {
        $this->user = $user;
        if($user)
            $this->user_id = $user->id;
        $this->statisticsService->setUser($user);
    }
    
    /**
     * 해당 옵션에 대한 솔루션 가져오기
     *
     * @param array $inputs
     * @return paginate of Solution
     */
    public function getSolutionsByOption(array $inputs)
    {
        return $this->solutionRepository
                    ->getSolutionsByOption($this->user_id, $inputs)
                    ->paginate($this->paginateCount);
    }


    /**
     * 솔루션 생성
     *
     * @param array $request
     * @return App\Models\Solution
     */
    public function createSolution(array $request)
    {
        DB::beginTransaction();
        try {

            $solution = $this->solutionRepository->create($request);
            
            $this->codeRepository->create([
                'id' => $solution->id,
                'code' => $request['code']
            ]);

            // 코드가 들어가면 대기중으로 전환
            
            $this->statisticsService
                 ->addSubmit($request['problem_id']);
            
            // I think this approach is bad. but using for performance.
            $solution->update(['result_id'=>Result::waitCode]);

        } catch(\Exception $e) {
            DB::rollback();
            abort(404);
        }
        DB::commit();
        return $solution;
    }
    
    
    /**
     * 강제로 채점하기 (관리자용)
     *
     * @param int $solution_id
     * @param int $result_id
     * @return boolean
     */
    public function updateReadyToResult($solution_id, $result_id)
    {
        $solution = $this->solutionRepository->get($solution_id);
        if(!$solution || $solution->result_id > 3)
            return false;
        
        DB::beginTransaction();
        try {
            $this->statisticsService
                 ->addResult($solution->user_id, $solution->problem_id, $result_id);
        
            $solution->update(['result_id' => $result_id]);
        } catch(\Exception $e) {
            DB::rollback();
            abort(404);
        }
        DB::commit();
        return true;
    }
    
    /**
     * 재채점하기 (관리자용)
     *
     * @param int $problem_id
     * @return void
     */
    public function rejudge($problem_id)
    {
        DB::beginTransaction();
        try {
            $this->statisticsService
                 ->removeStatistics($problem_id);
            $this->solutionRepository
                 ->updateStatusByProblem($problem_id, Result::waitCode);
        } catch(\Exception $e) {
            var_dump($e);
            DB::rollback();
            abort(404);
        }
        DB::commit();
        return true;
    }
    
    /**
     * 솔루션 가져오기
     *
     * @param int $solution_id
     * @return App\Models\Solution
     */
    public function getSolution($solution_id)
    {
        return $this->solutionRepository
                    ->getSolution($this->user_id, $solution_id)
                    ->firstOrFail();
    }
    
    public function getLatestSubmit($user_id)
    {
        return $this->solutionRepository
                    ->getLatestSubmit($user_id);
    }
}
