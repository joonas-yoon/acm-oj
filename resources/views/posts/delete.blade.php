@extends('master')

@section('title')
  글 삭제 - {{ $post->title }}
@stop

@section('content')
  <div class="ui container">
    {{-- @include('posts.nav') --}}
    
    <div class="ui icon negative message">
      <i class="warning sign icon"></i>
      <div class="content">
        <div class="header">
          이 게시글을 삭제합니다.
        </div>
        <p>삭제된 게시글은 복구가 불가능하오니, 신중하게 결정해주시길 바랍니다.</p>
      </div>
    </div>
    
    <h3 class="ui dividing header">
      <a href="/posts/{{ $post->id }}">
        {{ $post->title }}
      </a>
    </h3>
    
    {!! Form::model($post, ['method' => 'delete', 'route' => ['posts.destroy', $post->id], 'class' => 'ui form']) !!}
    {!! csrf_field() !!}
      
      @include('errors.list')
      
      @include('posts.form-show', compact('post'))
      
      <div class="ui divider"></div>
      
      @if( $post->commentsCount > 0 )
      <div class="ui icon negative message">
        <i class="warning sign icon"></i>
        <div class="content">
          <div class="header">
            정말 삭제하시겠습니까?
          </div>
          <p>
            <b>총 <a href="{{ action('PostsController@show', $post->id) }}#comments">{{ $post->commentsCount }}개의 댓글</a>이 있습니다.</b>
            <br/>댓글 작성자의 글도 <b>함께 사라지오니</b>, 다시 한 번 생각해주시길 바랍니다.
          </p>
        </div>
      </div>
      @endif
      
      {!! Form::submit('삭제하기', ['class' => 'ui negative button']) !!}
      <a href="{{ action('PostsController@show', $post->id) }}" class="ui basic button">돌아가기</a>
      
    {!! Form::close() !!}
  </div>
@stop

@section('script')
  <script>
  $('.date.popup').popup();
  </script>
@stop