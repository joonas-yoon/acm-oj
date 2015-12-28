<?php

namespace App\Http\Controllers;

use App\Models\Result,
    App\Models\Language,
    App\Models\Problem;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use SolutionService;

use Input;
use Sentinel;
use Carbon\Carbon;

class SolutionsController extends Controller
{

    /**
     * Instantiate a new SolutionsController instance.
     */
    public function __construct()
    {
        parent::__construct();
        
        $user = Sentinel::getUser();
        SolutionService::setUser($user);
        
        $this->middleware('auth', [
            'except' => [
                'index'
            ]
        ]);
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

        $solutions = SolutionService::getSolutionsByOption([
            'problem_id' => $problem_id,
            'username'   => $username,
            'lang_id'    => $lang_id,
            'result_id'  => $result_id
        ]);

        // $solutions = $solutions->paginateFrom(Input::get('top', ''), 20);
        //$solutions = $solutions->paginate(20, ['url' => \Request::url()]);

        $getUser_id = SolutionService::getUser();
        if($getUser_id)
            $getUser_id = $getUser_id->id;
        
        return view('solutions.index', compact(
            'fromWhere', 'solutions',
            'problem_id', 'username', 'result_id', 'resultRefs', 'lang_id', 'langRefs', 'acceptCode',
            'getUser_id'
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
        $request['result_id'] = Result::tempCode;
        $request['size'] = strlen($request->code);
        $request['is_hidden'] = false;
        $request['is_published'] = isset($request->is_published);
        
        $user_id = Sentinel::getUser()->id;
        $lastest = SolutionService::getLatestSubmit($user_id);
        if( diff_timestamp($lastest->created_at) < 1*60 ) {
            return redirect()->back()
                             ->with('error', '1분 후에 다시 시도해주세요.');
        }
        
        SolutionService::createSolution($request->all());
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
        $solution = SolutionService::getSolution($id);
        $code = $solution->code;

        if( $solution->is_hidden )
            return abort(404);
        
        if( $solution->problem->status != Problem::openCode )
            return abort(404);
                
        if( Sentinel::getUser()->id != $solution->user_id ) {
            // 다른 사람의 코드의 경우
            // 그 코드가 공개된 코드 && 내가 그 문제를 해결
            
            if( ! $solution->is_published ||
                ! $solution->statisticses->first() )
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
