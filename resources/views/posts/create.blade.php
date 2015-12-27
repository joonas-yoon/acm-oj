@extends('master')

@section('title')
  글 쓰기
@stop

@section('content')
  <div class="ui container">
    @include('posts.nav')
    
    {!! Form::open(['method' => 'PUT', 'class'=>'ui form']) !!}
    {!! csrf_field() !!}
      
      @include('errors.list')
    
      @include('posts.form', ['submitButtonText' => '작성하기'])
      
    {!! Form::close() !!}
  </div>
@stop

@section('script')
  @include('includes.editor-script')
  <script>
  </script>
@stop