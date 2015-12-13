<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Services\ProblemService;

class PagesController extends Controller
{
    
    public $problemService;
    
    public function __construct
    (
        ProblemService $problemService
    )
    {
        $this->problemService = $problemService;
    }
    
    function index() {
        $addedProblems = $this->problemService->getNewestProblems(6);

        return view('pages.index', compact('addedProblems'));
    }

    function about() {
        return view('pages.about');
    }
}
