@extends('master')

@section('title')
  {{ isset($title) ? $title : '' }}
@stop

@section('content')
<div class="ui container">
  
  @include('problems.nav')

  <table class="ui compact striped text-center table unstackable">
    <thead>
      <tr>
        <th class="one wide">번호</th>
        <th class="ten wide">문제 제목</th>
        <th class="one wide">정답</th>
        <th class="one wide">제출</th>
        <th class="three wide">정답률</th>
      </tr>
    </thead>
    <tbody>
      @foreach($problems as $problem)
      <tr>
        <td>
          {{ $problem->id }}
        </td>
        <td class="left aligned">
          <a href="{{ url('/problems/'.$problem->id) }}">{{ $problem->title }}</a>&nbsp;&nbsp;

          @if( $problem->is_special )
            <a class="ui teal basic label">스페셜 저지</a>
          @endif

          @if( Sentinel::check() )
            @if( ($uac = ($problem->statisticses->first()? $problem->statisticses->first()->count: -1)) > 0 )
              <a class="ui green basic label">해결</a>
            @elseif( $uac == 0 )
              <a class="ui red basic label">도전 중</a>
            @endif
          @endif
        </td>
        <td>
          <a href="/solutions/?problem_id={{ $problem->id }}&result_id={{ $resultAccCode }}">
            {{ $ac = ($problem->problemStatisticses->first()? $problem->problemStatisticses->first()->count : 0) }}
          </a>
        </td>
        <td>
          <a href="/solutions/?problem_id={{ $problem->id }}">
            {{ $sc = $problem->total_submit }}
          </a>
        </td>
        <td>
          <div class="ui indicating small progress" data-value="{{ StatisticsService::getRate($ac, $sc) }}">
            <div class="bar"></div>
            <div class="label">{{ number_format(StatisticsService::getRate($ac, $sc), 2) }} %</div>
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