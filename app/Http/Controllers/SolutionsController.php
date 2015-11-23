<?php

namespace App\Http\Controllers;

use App\Solution;
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
        $solutions = Solution::where('is_hidden', false)->orderBy('id', 'desc');

        $fromWhere = Input::get('from', null);

        if( ($problem_id = Input::get('problem_id', '')) > 0 ){
            $temp = $solutions->where('problem_id', $problem_id);
            if( $temp->count() > 0 ) $solutions = $temp;
        }

        if( ($result_id = Input::get('result_id', '')) > 0 ){
            $temp = $solutions->where('result_id', $result_id);
            if( $temp->count() > 0 ) $solutions = $temp;
        }

        $solutions = $solutions->paginate(20);

        return view('solutions.index', compact(
            'solutions', 'problem_id', 'result_id', 'fromWhere'
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

        $validator = \Validator::make($request->all(), [
            'problem_id' => 'required|numeric|min:0',
            'lang_id'    => 'required|numeric|min:0',
            'user_id'    => 'required',
            'code'       => 'required|min:2'
        ]);

        if ($validator->fails()) {
            return \Redirect::back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $solution = new Solution($request->all());
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
        //
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
