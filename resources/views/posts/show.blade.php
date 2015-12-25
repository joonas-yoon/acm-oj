@extends('master')

@section('head')
  <!-- prism source code highlighter -->
  <link href="/assets/prism.css" rel="stylesheet" type="text/css">
  <script type="text/javascript" src="/assets/prism.js"></script>
@stop

@section('title')
  글 읽기: {{ $post->title }}
@stop

@section('content')
  <div class="ui container">
    
    {{-- @include('posts.nav') --}}
    <div class="ui tabular menu">
      <a href="/posts" class="item active">게시판 전체</a>
      <a href="/posts/create" class="item">글쓰기</a>
    </div>
    
    <h2 class="ui header">
      <a href="/posts/{{ $post->id }}">{{ $post->title }}</a>
    </h2>
    
    <div class="ui threaded comments">
      
      <div class="comment">
        <a class="avatar">
          <img src="{{ $post->user->photo_link }}">
        </a>
        <div class="content">
          <a class="author" href="/user/{{ $post->user->name }}">{{ $post->user->name }}</a>
          <div class="metadata">
            <a style="color:inherit;" class="date popup" data-content="{{ $post->created_at->format('Y년 m월 d일 H시 i분') }}" data-variation="inverted">
              {{ $post->created_at->diffForHumans() }}
            </a>
          </div>
          <div class="text">
            {!! $post->content !!}
          </div>
        </div>
      </div>
      
      <div class="ui horizontal divider">댓글</div>
    
      @foreach($post->comments as $comment)
      <div class="comment">
        <a class="avatar">
          <img src="{{ $comment->user->photo_link }}">
        </a>
        <div class="content">
          <a class="author" href="/user/{{ $comment->user->name }}">{{ $comment->user->name }}</a>
          <div class="metadata">
            <a style="color:inherit;" class="date popup" data-content="{{ $comment->created_at->format('Y년 m월 d일 H시 i분') }}" data-variation="inverted">
              {{ $comment->created_at->diffForHumans() }}
            </a>
          </div>
          <div class="text">
            {!! $comment->content !!}
          </div>
        </div>
      </div>
      @endforeach
      
      @if( Sentinel::check() )
      {!! Form::open(['url' => action('PostsController@storeComment'), 'method' => 'PUT', 'class'=>'ui form']) !!}
      {!! Form::hidden('parent_id', $post->id) !!}
        @include('errors.list')
        
      <div class="comment">
        <a class="avatar">
          <img src="{{ Sentinel::getUser()->photo_link }}">
        </a>
        <div class="content">
          <div class="text">
            <textarea id="editor" name="content" class="html-editor-simple">
              {!! old('content') !!}
            </textarea>
          </div>
          <button type="submit" class="ui blue button">댓글 쓰기</button>
        </div>
      </div>
      {!! Form::close() !!}
      @endif
    </div>
  
    <div class="ui hidden divider"></div>
  </div>
@stop

@section('script')
  @include('includes.editor-script')
  <script>
  $('.date.popup').popup();
  </script>
@stop