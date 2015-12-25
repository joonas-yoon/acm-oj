<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use PostService;

use Sentinel;

class PostsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->middleware('auth', [
            'except' => [
                'index', 'show'
            ]
        ]);
        
        $user = Sentinel::getUser();
        PostService::setUser($user);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = PostService::getPosts();
        foreach($posts as $post){
            array_set($post, 'commentsCount', PostService::getComments($post->id)->count());
        }
        
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\CreatePostRequest $request)
    {
        $post = PostService::createPost($request->all());
        
        return redirect()->route('posts.show', $post->id);
    }
    
    public function storeComment(Requests\CreateCommentRequest $request)
    {
        $post = PostService::createComment($request->all());
        
        return redirect()->route('posts.show', $post->parent_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = PostService::getPost($id);
        
        $post->comments = PostService::getComments($id)->get();
        
        return view('posts.show', compact('post'));
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
