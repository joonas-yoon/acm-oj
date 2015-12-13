<?php

namespace App\Repositories;

use App\Models\Solution;

class SolutionRepository extends BaseRepository
{
    public function __construct(Solution $solution)
    {
        $this->model = $solution;
    }
    
    
    public function solutionsAccept()
    {
        return $this->solutions()->where('result_id', \App\Result::getAcceptCode());
    }
    
    public function getSolutionsByOption(array $inputs)
    {
        $query = $this->model->select('solutions.*');

        // 채점번호의 역순, 공개된 제출만
        $query->latest('solutions.id')->where('is_hidden', false);

        // 채점하는 문제가 공개된 것일 경우만
        $query->join('problems', function($join) {
            $join->on('problems.id', '=', 'solutions.problem_id');
        })->where('status',1);

        // 문제번호로 검색
        $problem_id = array_get($inputs, 'problem_id', 0);
        if($problem_id > 0)
            $query->where('problem_id', $problem_id);

        // 유저이름으로 검색
        $username = array_get($inputs, 'username', '');
        if($username != '')
            $query->join('users', function($join) {
              $join->on('users.id', '=', 'solutions.user_id');
            })->where('name', $username);


        // 언어종류로 검색
        $lang_id = array_get($inputs, 'lang_id', 0);
        if($lang_id > 0)
            $query->where('lang_id', $lang_id);

        // 결과종류로 검색
        $result_id = array_get($inputs, 'result_id', 0);
        if($result_id > 0)
            $query->where('result_id', $result_id);

        return $query;
    }
}

?>