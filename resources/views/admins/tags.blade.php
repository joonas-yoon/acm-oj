@extends('admins.layouts.master')

@section('title')
  태그 관리
@stop

@section('pre-content')
<h1 class="ui header">
  태그 관리
</h1>
<div class="sub header">
  현재 등록된 태그와 요청된 태그를 관리합니다.
</div>
@stop

@section('content')

  <style>
    .dividing.header{margin-top:2em;margin-bottom:1em;}
  </style>
  
  <h3 class="ui dividing header">현재 등록된 태그들</h3>
  
  @include('pagination.default', ['paginator' => $tags])
  
  <div class="ui relaxed middle aligned divided selection list">
  @forelse( $tags->sortByDesc('updated_at') as $tag )
    <div class="item">
    @if( $tag->status == \App\Models\Tag::openCode )
      <div class="right floated content">
        <div class="ui icon vk button" data-content="수정하기">
          <i class="write icon"></i>
        </div>
        <a class="ui icon negative button" href="/tags/{{ $tag->id }}/publish/n" data-content="숨기기">
          <i class="trash icon"></i>
        </a>
      </div>
      <div class="content">
        <a class="header" href="{{ action('TagsController@show', $tag->id) }}">{{ $tag->name }}</a>
        <div class="description" style="padding-top:2px">
          <p>이 태그와 연결된 <b><a href="{{ action('TagsController@problems', $tag->id) }}">{{ $tag->problemTags->count() }}개의 문제</a></b>가 있습니다.</p>
        </div>
      </div>
    @else
      <div class="right floated content">
        <div class="ui icon vk button" data-content="수정하기">
          <i class="write icon"></i>
        </div>
        <a class="ui icon positive button" href="/tags/{{ $tag->id }}/publish/y" data-content="공개하기">
          <i class="external icon"></i>
        </a>
      </div>
      <div class="content">
        <div class="header" style="color:rgba(0,0,0,.4);">{{ $tag->name }}</div>
        <div class="description" style="color:rgba(0,0,0,.4);padding-top:2px">
          <p>이 태그와 연결된 <b>{{ $tag->problemTags->count() }}개의 문제</b>가 있습니다.</p>
        </div>
      </div>
      @endif
    </div>
  @empty
    <div class="item">
      <div class="content">
        없음
      </div>
    </div>
  @endforelse
  </div>
  
  @include('pagination.default', ['paginator' => $tags])
  
@stop

@section('script')
  <script>
  $('.right.floated>.button').popup();
  </script>
@stop