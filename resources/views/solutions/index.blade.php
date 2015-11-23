@extends('master')

@section('content')

  <h2 class="ui header">
    <i class="flag icon"></i>
    <div class="content">
      채점 현황
      <div class="sub header">Submissions</div>
    </div>
  </h2>

  @if( $fromWhere == 'problem' )
  문제로부터 넘어옴
  @elseif( $fromWhere == 'contest' )
  대회로부터 넘어옴
  @endif

  <table class="ui striped blue table compact unstackable">
    <thead>
      <tr>
        <th>채점 번호</th>
        <th>제출자</th>
        <th>문제</th>
        <th>결과</th>
        <th>언어</th>
        <th>시간</th>
        <th>메모리</th>
        <th>코드 길이</th>
        <th>제출한 시간</th>
      </tr>
    </thead>
    <tbody>
    @foreach($solutions as $solution)
      <tr>
        <td>{{ $solution->id }}</td>
        <td>
          <a href="/user/{{ $solution->user->id }}">{{ $solution->user->name }}</a>
        </td>
        <td>
          <a class="popup title" href="/problems/{{ $solution->problem->id }}" data-content="{{ $solution->problem->title }}" data-variation="inverted">{{ $solution->problem->id }}</a>
        </td>
        <td>{!! $solution->resultToHtml() !!}</td>
        <td>{{ $solution->lang_id }}</td>
        @if( $solution->isAccepted() )
        <td>{{ $solution->time }} <span class="solution unit"> MS</span></td>
        <td>{{ $solution->memory }} <span class="solution unit"> KB</span></td>
        @else
        <td></td><td></td>
        @endif
        <td>{{ $solution->size }} <span class="solution unit"> B</span></td>
        <td>
          <a class="popup date" data-content="{{ $solution->created_at }}" data-variation="inverted">{{ $solution->created_at->diffForHumans() }}</a>
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>

  @include('pagination.byPivot', ['paginator' => $solutions])

@stop

@section('script')
  <script>
  $('a.popup.title').popup({ position : 'left center', transition: 'vertical flip' });
  $('a.popup.date').popup({ position : 'top center', transition: 'vertical flip' });
  </script>
@stop