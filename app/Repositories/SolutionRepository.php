<?php

namespace App\Repositories;

use App\Models\Solution,
    App\Models\Result;

class SolutionRepository extends BaseRepository
{
    public function __construct(Solution $solution)
    {
        $this->model = $solution;
    }
    
    
    public function solutionsAccept()
    {
        return $this->model->whereResult(Result::acceptCode);
    }
    
    public function getSolutionsByOption($user_id, array $inputs)
    {
        $query = $this->model->list()->withWired($user_id);

        // 채점번호의 역순, 공개된 제출만
        $query = $query->latest('solutions.id')->whereHidden(false);

        // 채점하는 문제가 공개된 것일 경우만
        $query = $query->joinProblem()->where('status',1);

        // 문제번호로 검색
        $problem_id = array_get($inputs, 'problem_id', 0);
        if($problem_id > 0)
            $query = $query->whereProblem($problem_id);

        // 유저이름으로 검색
        $username = array_get($inputs, 'username', '');
        if($username != '')
            $query = $query->joinUser()->whereName($username);


        // 언어종류로 검색
        $lang_id = array_get($inputs, 'lang_id', 0);
        if($lang_id > 0)
            $query = $query->whereLang($lang_id);

        // 결과종류로 검색
        $result_id = array_get($inputs, 'result_id', 0);
        if($result_id > 0)
            $query = $query->whereResult($result_id);

        return $query;
    }
    
    public function getSolution($user_id, $solution_id)
    {
        return $this->model->withWired($user_id)
                    ->whereSolution($solution_id);
    }
    
    public function getLatestSubmit($user_id = null)
    {
        if( ! $user_id ){
            return $this->model
                        ->orderBy('id', 'desc')
                        ->first();
        }
        
        return $this->model->orderBy('id', 'desc')
                    ->where('user_id', $user_id)
                    ->first();
    }
    
    public function updateStatusByProblem($problem_id, $result_id)
    {
        return $this->model->whereProblem($problem_id)
                    ->update(['result_id' => $result_id]);
    }
}

?>