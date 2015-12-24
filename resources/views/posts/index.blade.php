@extends('master')

@section('title')
  게시판 전체
@stop

@section('content')
  <div class="ui container">
    @include('posts.nav')
    
    <table class="ui stripted table fixed">
      <thead>
        <th class="two wide">분류</th>
        <th class="ten wide">제목</th>
        <th class="two wide">글쓴이</th>
        <th class="two wide center aligned">날짜/시간</th>
      </thead>
      <tbody>
      @foreach($posts as $post)
        <td>{{ str_random() }}</td>
        <td>{{ $post->title }}</td>
        <td>{{ $post->user->name }}</td>
        <td class="center aligned">
          <a href="#" class="date" data-content="{{ $post->created_at }}" data-variation="inverted">
          {{ $post->created_at->diffForHumans() }}
          </a>
        </td>
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