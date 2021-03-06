@extends('master')

@section('title')
  {{ isset($title) ? $title : '' }}
@stop

@section('content')
<div class="ui container">

  @include('problems.nav', ['tag' => $tag])

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
      @foreach($tags as $tag)
      <tr>
        <td>
          {{ $tag->problem->id }}
        </td>
        <td class="text-left">
          <a href="{{ url('/problems/'.$tag->problem->id) }}">{{ $tag->problem->title }}</a>&nbsp;&nbsp;

          @if( $tag->problem->is_special )
            <a class="ui teal basic label">스페셜 저지</a>
          @endif


          @if( Sentinel::check())
            @if( ($uac = ($tag->problem->statisticses->first()? $tag->problem->statisticses->first()->count: -1)) > 0 )
              <a class="ui green basic label">해결</a>
            @elseif( $uac == 0 )
              <a class="ui red basic label">도전 중</a>
            @endif
          @endif
        </td>
        <td>
          <a href="/solutions/?problem_id={{ $tag->problem->id }}&result_id={{ $resultAccCode }}">
            {{ $ac = ($tag->problem->problemStatisticses->first()? $tag->problem->problemStatisticses->first()->count : 0) }}
          </a>
        </td>
        <td>
          <a href="/solutions/?problem_id={{ $tag->problem->id }}">
            {{ $sc = $tag->problem->total_submit }}
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

  @include('pagination.default', ['paginator' => $tags])
</div>
@stop

@section('script')
  <script>
  $('.ui.progress').progress();
  </script>
@stop