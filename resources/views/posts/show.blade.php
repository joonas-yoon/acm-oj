@extends('master')

@section('head')
  <!-- prism source code highlighter -->
  <link href="/assets/prism.css" rel="stylesheet" type="text/css">
  <script type="text/javascript" src="/assets/prism.js"></script>
@stop

@section('title')
  글 읽기 - {{ $post->title }}
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
    
    @include('posts.form-show', compact('post'))
    
    <div class="ui horizontal divider">댓글</div>
    
    @include('posts.comments', ['parent' => $post])
    
  </div>
@stop

@section('script')
  @include('includes.editor-script')
  <script>
  $('.date.popup').popup();
  </script>
@stop