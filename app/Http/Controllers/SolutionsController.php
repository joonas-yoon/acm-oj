<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Solution;
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
        $solutions = Solution::where('is_hidden', false);

        $fromWhere = Input::get('from', null);

        if( ($problem_id = Input::get('problem_id', '-1')) > 0 ){
            $temp = $solutions->where('problem_id', $problem_id);
            if( $temp->count() > 0 ) $solutions = $temp;
        }

        if( ($result_id = Input::get('result_id', '-1')) > 0 ){
            $temp = $solutions->where('result_id', $result_id);
            if( $temp->count() > 0 ) $solutions = $temp;
        }

        $solutions = $solutions->paginate(20);

        return view('solutions.index', compact('solutions', 'fromWhere'));
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
    public function store(Request $request)
    {
        $solution = new Solution($request->all());
        //something ->save($solution);
        //return redirect('/problems/'. $solution->;
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
    public function update(Request $request, $id)
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
