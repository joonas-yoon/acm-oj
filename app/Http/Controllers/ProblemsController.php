<?php

namespace App\Http\Controllers;

use App\Problem;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use Input;
use Storage;

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
    public function create($step = '')
    {
        if( $step == 'data' ){
            // 내용은 작성된 상태고, 데이터를 추가하는 폼
            // 여러개를 고려해 get으로 설정
            // TODO: 접근 권한도 추가해야한다.
            $problem_id = Input::get('problem');
            $problem_id = Problem::findOrFail($problem_id)->id;

            return view('problems.maker.data', compact('problem_id'));
        }
        else if( $step == 'finish' ){
            return view('problems.maker.finish');
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
    public function store(Requests\CreateProblemRequest $request)
    {
        $problem = new Problem($request->all());
        $problem->save();

        return redirect('/problems/create/data?problem='. $problem->id);
    }

    public function storeData(Request $request)
    {
        // 권한 확인 필요
        $problem_id = $request->get('problem');
        $problem = Problem::findOrFail($problem_id);

        $files = $request->file('dataFiles');
        $filesNumber = sizeof($files);

        // 파일 갯수는 최대 100개 (50개의 테스트케이스 * 2개의 in/out)
        if( 100 < $filesNumber ){
            return Redirect::back()->withErrors([
                "요청하신 파일의 갯수가 너무 많습니다."
            ]);
        }

        // 파일 갯수는 항상 2 이상의 짝수 (in/out 1쌍)
        if( $filesNumber < 2 || $filesNumber % 2 ){
            return Redirect::back()->withErrors([
                "올바른 파일 개수인지 확인하십시오"
            ]);
        }

        $casesNumber = $filesNumber / 2;

        // 이름순으로 정렬
        sort($files);

        for($case=0; $case < $casesNumber; ++$case){
            $iFile = $files[$case*2];
            $oFile = $files[$case*2+1];

            $iFileName = pathinfo($iFile->getClientOriginalName(), PATHINFO_FILENAME);
            $oFileName = pathinfo($oFile->getClientOriginalName(), PATHINFO_FILENAME);

            if($iFileName != $oFileName)
                return Redirect::back()->withErrors([
                    "같은 이름의 in/out 쌍을 찾을 수 없음"
                ]);

            if($iFile->getClientOriginalExtension() != 'in' &&
               $oFile->getClientOriginalExtension() != 'out')
                return Redirect::back()->withErrors([
                    "파일 확장자를 확인하십시오"
                ]);
        }

        $fileDirectory = "data/{$problem_id}";
        $fileList = "";

        for($case=0; $case < $casesNumber; ++$case){
            $iFile = $files[$case*2];
            $oFile = $files[$case*2+1];

            $iFileName = pathinfo($iFile->getClientOriginalName(), PATHINFO_FILENAME);
            $oFileName = pathinfo($oFile->getClientOriginalName(), PATHINFO_FILENAME);

            $iFileContents = str_replace(array("\r\n", "\r", "\n"), "\n", file_get_contents($iFile->getRealPath()));
            $oFileContents = str_replace(array("\r\n", "\r", "\n"), "\n", file_get_contents($oFile->getRealPath()));

            Storage::put(
                "{$fileDirectory}/{$iFileName}.in",
                $iFileContents
            );
            Storage::put(
                "{$fileDirectory}/{$oFileName}.out",
                $oFileContents
            );

            $fileList .= "{$fileDirectory}/{$iFileName}.in\n";
            $fileList .= "{$fileDirectory}/{$oFileName}.out\n";
        }

        /*
        입력파일 형식

        테스트케이스 수(n)
        시간제한(t) 메모리제한(m) 스페셜저지여부(0/1)
        if(스페셜저지인 경우) spj 언어 (string)
        테스트케이스1 입력파일(data/1000/input1.txt)
        테스트케이스1 출력파일(data/1000/output1.txt)
        */

        $metaInfoContext  = "{$casesNumber}\n";
        $metaInfoContext .= "{$problem->time_limit} {$problem->memory_limit} {$problem->is_special}\n";
        if($problem->is_special) $metaInfoContext .= "C++\n";

        Storage::put(
            "{$fileDirectory}/input.txt",
            $metaInfoContext . $fileList
        );

        return redirect('/problems/create/finish');
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
