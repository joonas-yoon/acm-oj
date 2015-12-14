@extends('master')

@section('title')
태그 목록
@stop

@section('content')
<div class="ui container">

    @include('problems.nav')
    
    <div class="ui hidden divider"></div>

    <div class="ui four doubling cards">
    @foreach( $tags as $tag )
    <div class="ui fluid card">
      <div class="content">
        <i class="right floated star icon"></i>
        <div class="header">{{ $tag->name }}</div>
        <div class="description">
          <p>{{ $tag->id }}번 태그</p>
          <p>{{ $tag->problemTag->count() }}개의 문제</p>
        </div>
      </div>
      <div class="extra content">
        <span class="left floated"><i class="star icon"></i> 0 개의 평가</span>
      </div>
    </div>
    
    @endforeach
    </div>

</div>
@stop

@section('script')
  <script>
    
  </script>
@stop