<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    function index() {
        $problems = \App\Problem::where('status', true);
        $addedProblems = $problems->limit(6)->get();

        return view('pages.index', compact('addedProblems'));
    }

    function about() {
        return view('pages.about');
    }
}
