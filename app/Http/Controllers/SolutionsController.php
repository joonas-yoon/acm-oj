<?php

namespace App\Http\Controllers;

use App\Models\Result,
    App\Models\Language;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use App\Services\SolutionService,
    App\Services\ProblemService,
    App\Services\StatisticsService;

use Input;
use Sentinel;
use Carbon\Carbon;

class SolutionsController extends Controller
{
    public $problemService;
    public $solutionService;
    
    /**
     * Instantiate a new SolutionsController instance.
     */
    public function __construct
    (
        SolutionService $solutionService,
        ProblemService $problemService,
        StatisticsService $statisticsService
    )
    {
        $this->solutionService = $solutionService;
        $this->problemService = $problemService;
        $this->statisticsService = $statisticsService;
        
        $this->middleware('auth', [
            'except' => [
                'index'
            ]
        ]);
        
        Carbon::setLocale('ko');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fromWhere = Input::get('from', null);

        // Problem --------------------------------------------------
        $problem_id = Input::get('problem_id', '');

        // User -----------------------------------------------------
        $username = Input::get('user', '');

        // Result ---------------------------------------------------
        $resultRefs = Result::all();
        $result_id = Input::get('result_id', 0);

        // Language -------------------------------------------------
        $lang_id = Input::get('lang_id', 0);

        $langRefs = Language::all();
        
        $acceptCode = Result::acceptCode;

        $solutions = $this->solutionService->getSolutionsByOption([
            'problem_id' => $problem_id,
            'username'   => $username,
            'lang_id'    => $lang_id,
            'result_id'  => $result_id
        ]);

        // $solutions = $solutions->paginateFrom(Input::get('top', ''), 20);
        //$solutions = $solutions->paginate(20, ['url' => \Request::url()]);
        
        $getUser_id = Sentinel::check() ? Sentinel::getUser()->id : null;
        
        $amAccepted = function($uid, $pid){
            return $uid ? $this->statisticsService->isAcceptedProblem($uid, $pid) : false;
        };

        return view('solutions.index', compact(
            'fromWhere', 'solutions',
            'problem_id', 'username', 'result_id', 'resultRefs', 'lang_id', 'langRefs', 'acceptCode',
            'amAccepted', 'getUser_id'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\CreateSolutionRequest $request)
    {
        $request['user_id'] = Sentinel::getUser()->id;
        $request['result_id'] = Result::tempCode;
        $request['size'] = strlen($request->code);
        $request['is_hidden'] = false;
        $request['is_published'] = isset($request->is_published);

        $validator = \Validator::make($request->all(), [
            'problem_id' => 'required|numeric|min:1',
            'lang_id'    => 'required|numeric|min:1',
            'code'       => 'required|min:1',
            'user_id'    => 'required',
            'size'       => 'required'
        ], [
            'problem_id.required' => '문제의 상태를 확인해주세요.',
            'lang_id.required'    => '언어를 선택하세요.',
            'lang_id.min'         => '언어를 선택하세요.',
            'code.required'       => '소스 코드가 너무 짧습니다.',
            'code.min'            => '소스 코드가 너무 짧습니다.'
        ]);

        if ($validator->fails()) {
            return \Redirect::back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $this->solutionService->createSolution($request->all());
        return redirect('/solutions/?from=problem&problem_id=' . $request->problem_id );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $solution = $this->solutionService->getSolution($id);
        $code = $solution->code;

        if( $solution->is_hidden )
            return abort(404);
                
        if( Sentinel::getUser()->id != $solution->user_id ) {
            // 다른 사람의 코드의 경우
            // 그 코드가 공개된 코드 && 내가 그 문제를 해결
            
            if( ! $solution->is_published ||
                ! $this->statisticsService->isAcceptedProblem(Sentinel::getUser()->id, $solution->problem_id) )
                return abort(404);
        }
        
        $acceptCode = Result::acceptCode;
        
        return view('solutions.show', compact('code', 'solution', 'acceptCode'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\CreateSolutionRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
