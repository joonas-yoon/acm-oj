<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
#use Request;
use Sentinel;

class ArticlesController extends Controller
{
    /**
     * Instantiate a new ArticlesController instance.
     */
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => [
                'index', 'show'
            ]
        ]);

        //$this->middleware('log', ['only' => ['fooAction', 'barAction']]);
    }
    
    public function index() {
        $articles = Article::latest('published_at')->published()->get();

        return view('articles.index', compact('articles'));
    }

    public function show($id) {
        $article = Article::findOrFail($id);

        return view('articles.show', compact('article'));
    }

    public function create() {
        return view('articles.create');
    }

    public function store(Requests\CreateArticleRequest $request) {
        $article = new Article($request->all());
        Sentinel::getUser()->articles()->save($article);
        return redirect('/articles');
    }

    public function edit($id) {
        $article = Sentinel::user()->articles()->findOrFail($id);
        //$article = Article::findOrFail($id);

        return view('articles.edit', compact('article'));
    }

    public function update($id, Requests\UpdateArticleRequest $request) {
        $article = Article::findOrFail($id);
        $article->update($request->all());
        return redirect('/articles/'.$article->id);
    }
}
