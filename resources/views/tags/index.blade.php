@extends('master')

@section('title')
태그 목록
@stop

@section('content')
<div class="ui container">

    @include('problems.nav')
    
    <div class="ui four doubling link cards">
    @foreach( $tags as $tag )
    <div class="ui card">
      <div class="content">
        <i class="right floated star icon"></i>
        <a class="header" href="/tags/{{ $tag->id }}">{{ $tag->name }}</a>
        <div class="meta">1004번의 인기 태그</div>
        
        <div class="ui small feed">
          <div class="event">
            <div class="content">
              <div class="summary">
                <a href="/tags/{{ $tag->id }}/problems">{{ $tag->problemTags->count() }} 개</a>의 문제
              </div>
            </div>
          </div>
          <div class="event">
            <div class="content">
              <div class="summary">
                 평점 7.4 : <div class="ui star rating" data-rating="3" data-max-rating="5"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      @if( Sentinel::check() )
      <div class="ui bottom attached button">
        <i class="star icon"></i>
        평가하기
      </div>
      @else
      <a class="ui bottom attached button" href="/login">
        <i class="unlock alternate icon"></i>
        로그인이 필요합니다
      </a>
      @endif
    </div>
    @endforeach
    </div>

</div>
@stop

@section('script')
  <script>
  $('.ui.rating').rating();
  </script>
@stop