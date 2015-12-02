<?php

namespace App\Http\Controllers;

use App\Result;
use App\Language;
use App\Solution;
use App\User;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use Input;

class SolutionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$solutions = Solution::latest('id')->where('is_hidden', false);

        $solutions = Solution::select('solutions.*')->latest('solutions.id')->where('is_hidden', false);

        // $solutions = $solutions->with('problem')
        //                       ->whereHas('problem', function($q) {
        //                           $q->where('status', 1);
        //                       });

        $solutions->join('problems', function($join) {
            $join->on('problems.id', '=', 'solutions.problem_id');
        })->where('status',1);

        $fromWhere = Input::get('from', null);

        // Problem --------------------------------------------------
        if( ($problem_id = Input::get('problem_id', '')) > 0 ){
            $solutions->where('problem_id', $problem_id);
            //$temp = $solutions->where('problem_id', $problem_id);
            //if( $temp->count() > 0 ) $solutions = $temp;
        }

        // User -----------------------------------------------------
        if( ($user_id = Input::get('user', '')) != '' ){

            $solutions->join('users', function($join) {
              $join->on('users.id', '=', 'solutions.user_id');
            })->where('name', $user_id);

            // $temp = $solutions->with('user')
            //     ->whereHas('user', function($q) use ($user_id){
            //         $q->where('name', $user_id);
            //     });

            // if( $temp->count() > 0 ) $solutions = $temp;

        }

        // Result ---------------------------------------------------
        // 표시되지 않을 결과들
        $beHidden = Result::getHiddenCodes();
        $resultRefs = Result::whereNotIn('id', $beHidden)->get();

        $result_id = Input::get('result_id', 0);

        if( ! in_array( $result_id, $beHidden ) ){
            $solutions->where('result_id', $result_id);
            //$temp = $solutions->where('result_id', $result_id);
            //if( $temp->count() > 0 ) $solutions = $temp;
        }

        // Language -------------------------------------------------
        if( ($lang_id = Input::get('lang_id', 0)) > 0 ){
            //$solutions->where('lang_id', $lang_id);
            $temp = $solutions->where('lang_id', $lang_id);
            if( $temp->count() > 0 ) $solutions = $temp;
        }

        $langRefs = Language::all();

        $solutions = $solutions->paginate(20);

        return view('solutions.index', compact(
            'fromWhere', 'solutions',
            'problem_id',
            'user_id',
            'result_id', 'resultRefs',
            'lang_id', 'langRefs'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $problem = \App\Problem::findOrFail($id);
        return view('solutions.create', compact('problem'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\CreateSolutionRequest $request)
    {
        $request['user_id'] = \Auth::user()->id;
        $request['result_id'] = 1;
        $request['size'] = strlen($request->code);

        $validator = \Validator::make($request->all(), [
            'problem_id' => 'required|numeric|min:0',
            'lang_id'    => 'required|numeric|min:0',
            'user_id'    => 'required',
            'code'       => 'required',
            'size'       => 'required'
        ]);

        if ($validator->fails()) {
            return \Redirect::back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $solution = new Solution($request->all());
        $solution->save();
        // 일단 코드를 수정으로 삽입했음
        \DB::table('codes')->insert(
            [ 'id' => $solution->id, 'code' => $request->code ]
        );

        // 코드가 들어가면 대기중으로 전환
        $solution['result_id'] = Result::getWaitCode();
        $solution->save();

        return redirect('/solutions/?problem_id=' . $request->problem_id
            . '&user_id=' . $request->user_id );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $code = \DB::table('codes')->where('id', $id)->first();

        return view('solutions.show', compact('code'));
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
