@extends('master')

@section('title')
  글 수정 - {{ $post->title }}
@stop

@section('content')
  <div class="ui container">
    {{-- @include('posts.nav') --}}
    
    <h2 class="ui dividing header" style="margin-bottom: 1.5em;">
      <a href="/posts/{{ $post->id }}">
        글 수정 - {{ $post->title }}
      </a>
    </h2>
    
    {!! Form::model($post, ['method' => 'PATCH', 'route' => ['posts.update', $post->id], 'class' => 'ui form']) !!}
    {!! csrf_field() !!}
      
      @include('errors.list')
    
      @include('posts.form', ['submitButtonText' => '수정하기'])
      
    {!! Form::close() !!}
  </div>
@stop

@section('script')
  @include('includes.editor-script')
  <script>
  </script>
@stop