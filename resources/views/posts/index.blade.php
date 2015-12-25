@extends('master')

@section('title')
  게시판 전체
@stop

@section('content')
  <div class="ui container">
    @include('posts.nav')
    
    <table class="ui stripted table compact fixed">
      <thead>
        <th class="two wide center aligned">분류</th>
        <th class="ten wide">제목</th>
        <th class="two wide">글쓴이</th>
        <th class="two wide center aligned">날짜/시간</th>
      </thead>
      <tbody>
      @foreach($posts as $post)
      <tr>
        <td class="center aligned">
          <a href="#" class="ui label disabled">준비중</a>
        </td>
        <td>
          <a href="/posts/{{ $post->id }}">
            {{ $post->title }}
            @if( $post->commentsCount > 0 )
            &nbsp;<a class="ui label tiny compact">{{ $post->commentsCount }}</a>
            @endif
          </a>
        </td>
        <td>
          <a href="/user/{{ $post->user->name }}">{{ $post->user->name }}</a>
        </td>
        <td class="center aligned">
          <a href="#" class="date" data-content="{{ $post->created_at }}" data-variation="inverted">
          {{ $post->created_at->diffForHumans() }}
          </a>
        </td>
      </tr>
      @endforeach
      </tbody>
    </table>
  </div>
@stop

@section('script')
  <script>
    $('td .date').popup({
    })
  </script>
@stop