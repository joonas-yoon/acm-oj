<?php

namespace App\Services;

use App\Repositories\SolutionRepository,
    App\Repositories\UserRepository,
    App\Repositories\CodeRepository,
    App\Repositories\StatisticsRepository,
    App\Repositories\ResultRepository;
    
use App\Services\StatisticsService;

use App\Models\Result,
    App\Models\Solution;

use DB;

class SolutionService
{
    protected $solutionRepository;
    protected $userRepository;
    protected $codeRepository;
    protected $statisticsRepository;
    protected $resultRepository;
    
    protected $statisticsService;
    
    public $paginateCount = 20;
    
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
     * 해당 옵션에 대한 솔루션 가져오기
     *
     * @param array $inputs
     * @return paginate of Solution
     */
    public function getSolutionsByOption(array $inputs)
    {
        return $this->solutionRepository
                    ->getSolutionsByOption($inputs)
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
        $request = array_only($request, Solution::$editable);
        
        DB::beginTransaction();
        try {

            $solution = $this->solutionRepository->create($request);
            
            $this->codeRepository->create([
                'id' => $solution->id,
                'code' => $request['code']
            ]);

            // 코드가 들어가면 대기중으로 전환
            
            $this->statisticsService
                 ->addSubmit($request['user_id'], $request['problem_id']);
            
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
     * 결과 업데이트 (관리자용)
     *
     * @param int $solution_id
     * @param int $result_id
     * @return boolean
     */
    public function updateResult($solution_id, $result_id)
    {
        /*
        $solution = $this->solutionRepository->get($solution_id);
        $statistics = Statistics::firstOrCreate([
            'user_id' => $solution->user_id, 
            'problem_id' => $solution->problem_id,
            'result_id' => $result_id
        ]);
        $statistics->increment('count');
        */
        return $this->solutionRepository
                    ->update($solution_id, ['result_id' => $result_id]);
    }
    
    /**
     * 솔루션 가져오기
     *
     * @param int $solution_id
     * @return App\Models\Solution
     */
    public function getSolution($solution_id)
    {
        return $this->solutionRepository->get($solution_id);
    }
}


?>