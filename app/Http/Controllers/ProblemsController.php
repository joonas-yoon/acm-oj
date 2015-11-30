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
        $problems = Problem::where('status', true)->paginate(20);

        $resultAccCode = \App\Result::getAcceptCode();

        return view('problems.index', compact('problems', 'resultAccCode'));
    }

    public function newProblems ()
    {
        $problems = Problem::latest('created_at')->latest('id')
                    ->where('status', true)
                    ->take(10)->get();

        $resultAccCode = \App\Result::getAcceptCode();

        return view('problems.index', compact('problems', 'resultAccCode'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($step = 1)
    {
        if( $step == 1 );
        else if( $step == 'data' ){
            // 내용은 작성된 상태고, 데이터를 추가하는 폼
            // 여러개를 고려해 get으로 설정
            // TODO: 접근 권한도 추가해야한다.
            $problem_id = Input::get('problem');
            $problem_id = Problem::findOrFail($problem_id)->id;

            return view('problems.maker.data');
        }

        return view('problems.maker.content');
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
    public function store(Requests\CreateProblemRequest $request, $step = 1)
    {
        if( $step == 1 ){
            $problem = new Problem($request->all());
            $problem->save();

            return redirect('/problems/create/data?problem='. $problem->id);
        }
        else if( $step == 'data' ){

            return storeData($request);
        }
        return \App::abort(404);
    }

    public function storeData(Requests $request)
    {
        var_dump($request->all());
        /*
        // 참고할 샘플코드
        $request->file('image')->move(
            base_path() . '/public/images/catalog/', $imageName
        );

        return \Redirect::route('admin.products.edit',
            array($product->id))->with('message', 'Product added!');

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
        $problem = Problem::where('status', true)->findOrFail($id);

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
    public function preview($id = 0)
    {
        return "preview {$id}";

        $problem = Problem::where('status', false)->findOrFail($id);

        $problem->description = $problem->getMdDescription();
        $problem->input       = $problem->getMdInput();
        $problem->output      = $problem->getMdOutput();
        $problem->hint        = $problem->getMdHint();

        return view('problems.show', compact('problem'));
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
