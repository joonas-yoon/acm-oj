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
        $request = array_only($request, Solution::$editable);
        $request = array_add($request, 'code', $code);
        return $this->service->createSolution($request);
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
        return $this->service->updateResult($solution_id, $result_id);
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
}
