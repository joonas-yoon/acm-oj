<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use ProblemService;

use Sentinel;

class PagesController extends Controller
{
    
    public $problemService;
    
    public function __construct
    (
        ProblemService $problemService
    )
    {
        $user = Sentinel::getUser();
        ProblemService::setUser($user);
    }
    
    function index()
    {
        $addedProblems = ProblemService::getNewestProblems(7);

        return view('pages.index', compact('addedProblems'));
    }

    function about() {
        return view('pages.about');
    }
}
