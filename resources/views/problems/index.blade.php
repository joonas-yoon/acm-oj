@extends('master')

@section('title')
  {{ isset($title) ? $title : '' }}
@stop

@section('content')
<div class="ui container">
  <h2 class="ui header">
    <div class="ui secondary menu right floated">
      <a class="item {{ \App\Helpers::setActiveStrict('problems') }}" href="/problems">문제</a>
      <a class="item {{ \App\Helpers::setActive('problems/new') }}" href="/problems/new">새로 추가된 문제</a>
      <a class="item">출처</a>
      <a class="item">태그</a>
      <a class="item {{ \App\Helpers::setActive('problems/create') }}" href="/problems/create/list">만들기</a>
    </div>

    <i class="book icon"></i>
    <div class="content">
      문제 목록
      <div class="sub header">Problems</div>
    </div>
  </h2>

  <table class="ui compact striped text-center table unstackable">
    <thead>
      <tr>
        <th class="one wide">번호</th>
        <th>문제 제목</th>
        <th>정답</th>
        <th>제출</th>
        <th>비율</th>
      </tr>
    </thead>
    <tbody>
      @foreach($problems as $problem)
      <tr>
        <td>
          {{ $problem->id }}
        </td>
        <td class="text-left">
          <a href="{{ url('/problems/'.$problem->id) }}">{{ $problem->title }}</a>&nbsp;&nbsp;

          @if( $problem->is_special )
            <a class="ui teal basic label">스페셜 저지</a>
          @endif


          @if( Sentinel::check())
            @if( $statisticsService->isAcceptedProblem(Sentinel::getUser()->id, $problem->id) )
              <a class="ui green basic label">해결</a>
            @elseif( $statisticsService->isTriedProblem(Sentinel::getUser()->id, $problem->id) )
              <a class="ui red basic label">도전 중</a>
            @endif
          @endif
        </td>
        <td>
          <a href="/solutions/?problem_id={{ $problem->id }}&result_id={{ $resultAccCode }}">
            {{ $ac = $statisticsService->getAcceptCountOfProblem($problem->id) }}
          </a>
        </td>
        <td>
          <a href="/solutions/?problem_id={{ $problem->id }}">
            {{ $sc = $statisticsService->getSubmitCountOfProblem($problem->id) }}
          </a>
        </td>
        <td>
          <div class="ui indicating small progress" data-value="{{ $statisticsService->getRate($ac, $sc) }}">
            <div class="bar"></div>
            <div class="label">{{ number_format($statisticsService->getRate($ac, $sc), 2) }} %</div>
          </div>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  @include('pagination.default', ['paginator' => $problems])
</div>
@stop

@section('script')
  <script>
  $('.ui.progress').progress();
  </script>
@stop