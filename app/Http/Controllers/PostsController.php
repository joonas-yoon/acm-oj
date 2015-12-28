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
        $user_id = Sentinel::getUser()->id;
        $lastest = PostService::getLatestSubmit($user_id);
        if( diff_timestamp($lastest->created_at) < 1*60 ) {
            return redirect()->back()
                             ->with('error', '도배 방지를 위해, 1분 이내에 글을 연속적으로 작성하실 수 없습니다.');
        }
        
        $post = PostService::createPost($request->all());
        
        return redirect()->route('posts.show', $post->id);
    }
    
    public function storeComment(Requests\CreateCommentRequest $request)
    {
        $user_id = Sentinel::getUser()->id;
        $lastest = PostService::getLatestSubmit($user_id);
        if( diff_timestamp($lastest->created_at) < 1*60 ) {
            return redirect()->back()
                             ->with('error', '도배 방지를 위해, 1분 이내에 글을 연속적으로 작성하실 수 없습니다.');
        }
        
        $post = PostService::createComment($request->all());
        
        if( $post->parent_on == 'problem' )
            return redirect()->route('problems.show', $post->parent_id);
        
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
        
        if( $this->isAuthorOfPost($post) ) {
            $post->edit_link = route('posts.edit', $post->id);
            $post->delete_link = route('posts.delete', $post->id);
        }
        
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
        $post = PostService::getPost($id);
        
        if( ! $this->isAuthorOfPost($post) )
            return abort(404);
        
        return view('posts.edit', compact('post'));
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
        $post = PostService::getPost($id);
        
        if( ! $this->isAuthorOfPost($post) )
            return abort(404);
        
        if( ! PostService::updatePost($post->id, $request->all()) )
            return abort(404);
        
        return redirect()->route('posts.show', $post->id);
    }
    
    public function delete($id)
    {
        $post = PostService::getPost($id);
        
        if( ! $this->isAuthorOfPost($post) )
            return abort(404);
            
        $post->commentsCount = PostService::getComments($id)->count();
        
        return view('posts.delete', compact('post'));
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = PostService::getPost($id);
        
        if( ! $this->isAuthorOfPost($post) )
            return abort(404);
            
        if( ! PostService::deletePost($post->id) )
            return abort(404);
            
        return redirect()->route('posts');
    }
    
    public function isAuthorOfPost($post, $user_id = null)
    {
        $user = Sentinel::check();
        if( ! $user ) return false;
        
        if( $user_id == null ) $user_id = $user->id;
        
        if( ! is_admin() && $user_id != $post->user_id ) return false;
        
        return true;
    }
}
