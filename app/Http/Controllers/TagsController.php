<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\Models\Language,
    App\Models\Result,
    App\Models\Tag;

use ProblemService;
use SolutionService;
use StatisticsService;
use TagService;

use Sentinel;

class TagsController extends Controller
{
    /**
     * Instantiate a new ProblemsController instance.
     */

    public function __construct()
    {
        $this->middleware('auth', [
            'except' => [
                'index', 'show', 'problems'
            ]
        ]);
        
        $user = Sentinel::getUser();
        ProblemService::setUser($user);
        StatisticsService::setUser($user);
        TagService::setUser($user);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = TagService::getOpenTagsWithProblem();

        //var_dump($tags->get());
        
        return view('tags.index', compact('tags'));
    }
    
    public function show($id)
    {
        $tag = Tag::findOrFail($id);
        
        $tags = TagService::getTagWithProblem($tag->id);
        $problemsCount = $tags->count();
        
        return view('tags.show', compact('tag', 'problemsCount'));
    }
    
    /**
     * Update status of the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function publish($id, $status = 'n')
    {
        if( ! is_admin() ) return abort(404);
        
        $tag = Tag::find($id);
        $status = $status == 'y' ? (Tag::openCode) : (Tag::hiddenCode);
        
        TagService::updateTag($tag->id, $status);
        
        return redirect()->back()->with('success', '['.$tag->name.']을 공개했습니다.');
    }
    
    /**
     * Display a listing of the resource with its problems connected;
     *
     * @return \Illuminate\Http\Response
     */
    public function problems($id)
    {
        $tag = Tag::findOrFail($id);
        
        $tags = TagService::getTagWithProblem($tag->id);

        $title = '문제 목록 - '. $tag->name . ' - '.$tags->currentPage().' 페이지';
        $resultAccCode = Result::acceptCode;
        
        return view('tags.problems', compact(
            'tag', 'tags', 'title', 'resultAccCode'
        ));
    }
}
