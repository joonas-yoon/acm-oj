@extends('admins.layouts.master')

@section('title')
  문제 관리
@stop

@section('pre-content')
<h1 class="ui header">
  문제 관리
</h1>
<div class="sub header">
  문제와 관련한 전반적인 인터페이스
</div>
@stop

@section('content')

  @include('pagination.default', ['paginator' => $problems])
  
  <div class="ui feed">
    @foreach( $problems->sortByDesc('updated_at') as $problem )
    <div class="event">
      <div class="label">
        <img src="{{ $problem->user->first()->photo_link }}">
      </div>
      <div class="content">
        <div class="summary">
          <a href="/problems/preview/{{ $problem->id }}">{{ $problem->id }}번 {{ $problem->title }}</a>
          &nbsp;가 대기중으로 전환되었습니다.
          <div class="date" data-content="{{ $problem->updated_at }}" data-variation="inverted">{{ $problem->updated_at->diffForHumans() }}</div>
        </div>
        @if( count($problem->tags) > 0 )
        <div class="extra content">
          @foreach( $problem->tags as $tag )
          <a class="ui label {{ $tag->status ? '':'disabled' }}" href="/tags/{{ $tag->id }}">
            <i class="tag icon"></i>
            {{ $tag->name }}
            
          </a>
          @endforeach
        </div>
        @endif
        <div class="meta">
          <a href="/user/{{ $problem->user->first()->name }}"><i class="pencil icon"></i> by {{ $problem->user->first()->name }}</a>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  
  @include('pagination.default', ['paginator' => $problems])
  
@stop

@section('script')
  <script>
  $('.event .content .date').popup();
  </script>
@stop