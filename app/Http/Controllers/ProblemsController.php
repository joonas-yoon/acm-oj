<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\Models\Language,
    App\Models\Problem,
    App\Models\Result,
    App\Models\User;

use StatisticsService;
use ProblemService;
use TagService;

use GrahamCampbell\Markdown\Facades\Markdown;

use Input;
use Storage;
use Sentinel;

class ProblemsController extends Controller
{
    /**
     * Instantiate a new ProblemsController instance.
     */
    
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => [
                'index', 'newProblems', 'show'
            ]
        ]);
        
        $this->middleware('admin', [
            'only' => [
                'publish'
            ]
        ]);
        
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
        $problems = ProblemService::getOpenProblems();

        $title = '문제 목록 - '.$problems->currentPage().' 페이지';
        $resultAccCode = Result::acceptCode;

        return view('problems.index', compact(
            'problems', 'title', 'resultAccCode'
        ));
    }

    public function newProblems ()
    {
        $problems = ProblemService::getNewestProblems(15);

        $title = '새로 추가된 문제 목록';
        $resultAccCode = Result::acceptCode;

        return view('problems.index', compact(
            'problems', 'title', 'resultAccCode'
        ));
    }

    public function creatingProblemsList()
    {
        $problems = ProblemService::getReadyProblemsByAuthor();

        $title = '문제 제작 - '.$problems->currentPage().' 페이지';
        return view('problems.maker.list', compact('problems', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($step = '')
    {
        if( $step == 'data' ){
            $problem_id = Input::get('problem');
            
            if( ! $this->amIAuthorOfProblem($problem_id) ) return abort(404);
            
            return view('problems.maker.data', compact('problem_id'));
        }
        else if( $step == 'finish' ){
            return view('problems.maker.finish');
        }

        return view('problems.maker.content');
    }
    
    /**
     * This have been used as SolutionController::create
     *
     * @return \Illuminate\Http\Response
     */
    public function createSolution($id)
    {
        $problem = ProblemService::getProblem($id);
        
        if( $problem->status != 1 ) {
            // 공개문제(1) 가 아니면 제출이 불가함
            return abort(404);
        }
        
        $languages = Language::all()->toArray();
        array_unshift($languages, [
            'id' => 0, 'name' => '선택하세요'
        ]);
        $languages = array_pluck($languages, 'name', 'id');
        $defaults = [
            'language'   => Sentinel::getUser()->default_language,
            'code_theme' => Sentinel::getUser()->default_code_theme,
        ];
        
        return view('solutions.create', compact('problem', 'languages', 'defaults'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\CreateProblemRequest $request)
    {
        $problem = ProblemService::createProblem($request->all());
        if( ! $this->amIAuthorOfProblem($problem->id) ) return abort(404);
        return redirect('/problems/create/data?problem='. $problem->id);
    }

    public function storeData(Request $request)
    {
        // 권한 확인 필요
        $problem_id = $request->get('problem');
        $problem = ProblemService::getProblem($problem_id);
        if( ! $this->amIAuthorOfProblem($problem->id) ) return abort(404);

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
        
        Storage::deleteDirectory($fileDirectory);

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
     * 공개된 문제만 볼 수 있음
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $problem = ProblemService::getProblem($id);
        
        if( $problem->status != Problem::openCode ){
            // 관리자라면 미리보기로 관리가 가능하도록 페이지 이동
            if( is_admin() ) return redirect( action('ProblemsController@preview', [$id]) );
            
            return abort(404);
        }
        
        $problem->description = Markdown::convertToHtml($problem->description);
        $problem->input       = Markdown::convertToHtml($problem->input);
        $problem->output      = Markdown::convertToHtml($problem->output);
        $problem->hint        = Markdown::convertToHtml($problem->hint);
        
        $problem->userAccept  = $problem->statisticses->first() ?
                                $problem->statisticses->first()->count : -1;

        $tags = TagService::getPopularTags($problem->id);
        
        return view('problems.show', compact('problem', 'tags'));
    }

    /**
     * 공개되지 않은 문제만을 볼 수 있음
     * 문제에 대한 관리 인터페이스가 존재함
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function preview($id)
    {
        $problem = ProblemService::getProblem($id);
        
        if( ! is_admin() ) {
            if( $problem->status != Problem::hiddenCode ) return abort(404);
        
            if( ! $this->amIAuthorOfProblem($problem->id) ) return abort(404);
        }
        
        $problem->description = Markdown::convertToHtml($problem->description);
        $problem->input       = Markdown::convertToHtml($problem->input);
        $problem->output      = Markdown::convertToHtml($problem->output);
        $problem->hint        = Markdown::convertToHtml($problem->hint);
        
        $problem->userAccept  = $problem->statisticses->first() ?
                                $problem->statisticses->first()->count : -1;

        $tags = TagService::getPopularTags($problem->id);

        return view('problems.show', compact('problem', 'tags'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $problem_id
     * @return \Illuminate\Http\Response
     */
    public function edit($problem_id)
    {
        $problem = ProblemService::getProblem($problem_id);

        if( ! is_admin() && $problem->status != Problem::hiddenCode ) {
            // 관리자가 아니라면
            // 숨겨진 문제(1) 가 아니면 접근 불가
            return abort(404);
        }
        
        // 자신이 작성한 문제만 접근
        if( ! $this->amIAuthorOfProblem($problem->id) ) return abort(404);
        
        //$selectedTags = TagService::getPopularTags($problem->id);
        
        return view('problems.maker.edit', compact('problem', 'tags'));
    }

    public function update(Requests\CreateProblemRequest $request, $id)
    {
        $problem = ProblemService::getProblem($id);
        if( ! $this->amIAuthorOfProblem($problem->id) ) return abort(404);
        
        ProblemService::updateProblem($problem->id, $request->all());
        
        $limitTagCount = TagService::getLimitTagCount();
        $tags = $request->get('tags');
        if( count($tags) > $limitTagCount ) {
            return redirect()->back()
                             ->withErrors('태그는 최대 '. $limitTagCount .'개까지만 등록할 수 있습니다.');
        }
        
        TagService::insertTags($problem->id, (array)$tags);
        
        if( $problem->status == Problem::openCode )
            return redirect( action('ProblemsController@index', $problem->id) );
        else
            return redirect( action('ProblemsController@preview', $problem->id) );
    }

    public function updateStatus(Request $request, $id)
    {
        if($request->from == 'confirm'){
            // 문제 검토 요청
            $request->merge(array('status' => Problem::readyCode)); // 문제 제작 완료
        }

        $validator = \Validator::make(
            $request->only('problem_id', 'status'),
            [
                'problem_id' => 'required|numeric',
                'status'     => 'required|numeric'
            ]
        );

        if( $validator->fails() ){
            return Redirect::back()->withErrors($validator);
        }

        $problem = ProblemService::getProblem($id);
        if( ! $this->amIAuthorOfProblem($problem->id) ) return abort(404);
        
        if( $problem )
            ProblemService::updateProblemStatus($problem->id, $request->status);

        return Redirect::back();
    }
    
    /**
     * Publish problem with changing status 0 to 1
     *
     * @param  int  $id
     * @return \Illuminate\Http\Redirect
     */
    public function publish($problem_id, $bool = '')
    {
        $problem = ProblemService::getProblem($problem_id);
        if( is_admin() && $problem ) {
            ProblemService::updateProblemStatus($problem->id, $bool != 'cancel' ? Problem::openCode : Problem::readyCode);
            return redirect()->back()->with('success', '관리자에게 성공적으로 요청되었습니다.');
        }
        return redirect()->back()->with('error', '요청에 실패했습니다');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function insertTags(Request $request)
    {
        $pid  = $request->get('problem_id');
        $tags = $request->get('tags');
        
        if( TagService::insertTags($pid, (array)$tags) )
            return redirect()->back();
        
        return redirect()->back()->with('error', '요청에 실패했습니다');
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
    
    
    private function amIAuthorOfProblem($problem_id)
    {
        if( is_admin() ) return true;
        
        if( ! Sentinel::check() ) return redirect()->guest('login');
        $author_id = ProblemService::getAuthorOfProblem($problem_id);
        return (Sentinel::getUser()->id == $author_id);
    }
}

