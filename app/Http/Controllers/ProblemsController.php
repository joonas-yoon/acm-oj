<?php

namespace App\Http\Controllers;

use App\Problem;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use Input;

class ProblemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $problems = Problem::where('is_published', true)->paginate(20);

        $resultAccCode = \App\Result::getAcceptCode();

        return view('problems.index', compact('problems', 'resultAccCode'));
    }

    public function newProblems ()
    {
        $problems = Problem::latest('created_at')->latest('id')
                    ->where('is_published', true)
                    ->take(10)->get();

        $resultAccCode = \App\Result::getAcceptCode();

        return view('problems.index', compact('problems', 'resultAccCode'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('problems.maker.content');
    }
    public function createData(Request $request, $step)
    {
        //var_dump($request->all());

        if( $step == 'preview' ){
            // 주어진 리퀘스트에서 미리 보기
            $problem = new Problem($request->all());

            $problem->description = $problem->getMdDescription();
            $problem->input       = $problem->getMdInput();
            $problem->output      = $problem->getMdOutput();
            $problem->hint        = $problem->getMdHint();

            return view('problems.show', compact('problem'));
        }
        else if( $step == 'data' ){
            // 데이터 등록과 함께 실제로 등록을 준비함

            return view('problems.maker.data');
        }
        else if( $step == 'finish' ){
            // 실제로 등록

            return '등록 완료!';
        }
        else if( $step == 5 ){
        }

        return '잘못된 접근';
    }

    private static function makerStepClass($val, $lv){
        if($val < $lv) return 'disabled';
        return $val > $lv ? '':'active';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\CreateProblemRequest $request)
    {
        $problem = new Problem($request->all());
        /*
        $problem->save();

        return redirect('/problems/' . $problem->id);
        */

        /*
        입력파일 형식

        테스트케이스 수(n)
        시간제한(t) 메모리제한(m) 스페셜저지여부(0/1)
        if(스페셜저지인 경우) spj 언어 (string)
        테스트케이스1 입력파일(data/1000/input1.txt)
        테스트케이스1 출력파일(data/1000/output1.txt)
        */

        $storedContext = [];

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $problem = Problem::where('is_published', true)->findOrFail($id);

        $problem->description = $problem->getMdDescription();
        $problem->input       = $problem->getMdInput();
        $problem->output      = $problem->getMdOutput();
        $problem->hint        = $problem->getMdHint();

        return view('problems.show', compact('problem'));
    }

    /**
     *
     * 틀만 잡아놓고 추후에 확인하는 작업을 추가하자.
     *
     */
    public function preview(Requests\CreateProblemRequest $request)
    {
        //$problem = new Problem($request->all());

        return view('problems.preview', compact('problem'));
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
