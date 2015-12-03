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

        $solutions = (new Solution)->getSolutionsByOption([
            'problem_id' => $problem_id,
            'username'   => $username,
            'lang_id'    => $lang_id,
            'result_id'  => $result_id
        ]);

        // $solutions = $solutions->paginateFrom(Input::get('top', ''), 20);
        $solutions = $solutions->paginate(20, ['url' => \Request::url()]);

        return view('solutions.index', compact(
            'fromWhere', 'solutions',
            'problem_id',
            'username',
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
