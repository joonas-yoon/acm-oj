<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Thank;

use StatisticsService;
use SolutionService;
use ProblemService;
use TagService;

use Session;
use Sentinel;

class AdminController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->middleware('admin');
        
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
    
    /**
     * 재채점 관리 페이지
     *
     * @return \Illuminate\Http\View
     */
    public function rejudge()
    {
        return view('admins.rejudge');
    }
    
    // 재채점 실행
    public function processRejudge(Request $request)
    {
        $problem_id = $request->get('problem_id');
        
        if( ! $problem_id ) {
            Session::flash('error', '잘못된 요청입니다.');
            return redirect()->back();
        }
        
        $problem = ProblemService::getProblem($problem_id);
        
        if( ! SolutionService::rejudge($problem->id) ) {
            Session::flash('error', '재채점을 실패했습니다.');
            return redirect()->back();
        }
        
        $message = $problem_id . '번 문제에 대한 재채점을 실행하였습니다.';
        $message .= '<a href="/solutions/?problem_id='. $problem_id ."\">"
                 . '&nbsp;보러가기</a>';
        
        Session::flash('success', $message);
        return redirect()->back();
    }
}
