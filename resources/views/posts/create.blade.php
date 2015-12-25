@extends('master')

@section('title')
  게시판 전체
@stop

@section('content')
  <div class="ui container">
    @include('posts.nav')
    
    {!! Form::open(['method' => 'PUT', 'class'=>'ui form']) !!}
    {!! csrf_field() !!}
      
      @include('errors.list')
    
      <div class="ui stackable grid">
        <div class="two wide column field column-label">제목</div>
        <div class="fourteen wide column field">
          {!! Form::text('title', old('title'), ['placeholder' => '게시글 제목']) !!}
        </div>
      </div>
      
      <div class="ui stackable grid">
        <div class="two wide column field column-label">내용</div>
        <div class="fourteen wide column field">
          <textarea id="editor" name="content" class="html-editor">
            {!! old('content') !!}
          </textarea>
        </div>
      </div>
      
      <div class="ui divider"></div>
      
      <div class="ui stackable grid">
        <div class="two wide column field"></div>
        <div class="fourteen wide column field">
          <button type="submit" class="ui primary button">작성하기</button>
        </div>
      </div>
      
    {!! Form::close() !!}
  </div>
@stop

@section('script')
  @include('includes.editor-script')
  <script>
  </script>
@stop