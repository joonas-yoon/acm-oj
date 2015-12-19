<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use StatisticsService;
use ProblemService;
use TagService;

use Sentinel;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function __construct()
    {
        // $this->middleware('admin', [        ]);
        parent::__construct();
        
        $user = Sentinel::getUser();
        ProblemService::setUser($user);
        TagService::setUser($user);
        StatisticsService::setUser($user);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('admins.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    
    
    /**
     * 문제 관리 페이지를 뿌린다.
     *
     * @return \Illuminate\Http\View
     */
    public function problems()
    {
        $problems = ProblemService::getReadyProblems();
        
        return view('admins.problems', compact('problems'));
    }
    
    
    /**
     * 태그 관리 페이지를 뿌린다.
     *
     * @return \Illuminate\Http\View
     */
    public function tags()
    {
        $tags = TagService::getTagsWithProblem();
                
        return view('admins.tags', compact('tags'));
    }
}
