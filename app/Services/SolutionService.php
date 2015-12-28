<?php

namespace App\Services;

use App\Services\Protects\SolutionServiceProtected;

use App\Models\Problem,
    App\Models\Solution;

use DB;

class SolutionService extends BaseService
{

    public function __construct
    (
        SolutionServiceProtected $solutionServiceProtected
    )
    {
        $this->service = $solutionServiceProtected;
    }

    /**
     * 해당 옵션에 대한 솔루션 가져오기
     *
     * @param array $inputs
     * @return paginate of Solution
     */
    public function getSolutionsByOption(array $request)
    {
        return $this->service->getSolutionsByOption($request);
    }


    /**
     * 솔루션 생성
     *
     * @param array $request
     * @return App\Models\Solution
     */
    public function createSolution(array $request)
    {
        if(Problem::findOrFail($request['problem_id'])->status != Problem::openCode)
            abort(404);
        $code = $request['code'];
        $request['user_id'] = $this->user->id;
        $request = array_only($request, Solution::$editable);
        $request = array_add($request, 'code', $code);
        return $this->service->createSolution($request);
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
        if($result_id < 4)
            return false;
        return $this->service->updateReadyToResult($solution_id, $result_id);
    }
    
    /**
     * 솔루션 가져오기
     *
     * @param int $solution_id
     * @return App\Models\Solution
     */
    public function getSolution($solution_id)
    {
        return $this->service->getSolution($solution_id);
    }
    
    /**
     * 모든 (또는 특정) 유저의 가장 최근에 제출된 항목을 가져오기
     *
     * @return Illuminate\Support\Collection
     */
    public function getLatestSubmit($user_id = null)
    {
        return $this->service->getLatestSubmit($user_id);
    }
    
    /**
     * 재채점하기 (관리자용)
     *
     * @param int $problem_id
     * @return void
     */
    public function rejudge($problem_id)
    {
        if( ! is_admin() ) return abort(404);
        
        return $this->service->rejudge($problem_id);
    }
}
