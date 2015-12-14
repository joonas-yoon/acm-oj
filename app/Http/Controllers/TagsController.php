<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\Models\Language,
    App\Models\Result,
    App\Models\Tag;

use App\Services\ProblemService,
    App\Services\StatisticsService,
    App\Services\TagService;

use Sentinel;

class TagsController extends Controller
{
    /**
     * Instantiate a new ProblemsController instance.
     */
    
    public $problemService;
    public $statisticsService; 
    public $tagService;
    
    public function __construct
    (
        ProblemService      $problemService,
        StatisticsService   $statisticsService,
        TagService          $tagService
    )
    {
        $this->middleware('auth', [
            'except' => [
                'index'
            ]
        ]);
        
        $this->problemService    = $problemService;
        $this->statisticsService = $statisticsService;
        $this->tagService        = $tagService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = $this->tagService->getOpenTagsWithProblem();
        $tagService = $this->tagService;

        //var_dump($tags->get());
        
        return view('tags.index', compact('tags', 'tagService'));
    }
    
    /**
     * Display a listing of the resource with its problems connected;
     *
     * @return \Illuminate\Http\Response
     */
    public function problems($id)
    {
        $tag = Tag::findOrFail($id);
        
        $tags = $this->tagService->getTagWithProblem($tag->id);
        $statisticsService = $this->statisticsService;

        $title = '문제 목록 - '. $tag->name . ' - '.$tags->currentPage().' 페이지';
        $resultAccCode = Result::acceptCode;
        
        return view('tags.problems', compact(
            'tag', 'tags', 'statisticsService', 'title', 'resultAccCode'
        ));
    }
}
