@extends('master')

@section('content')

  <h2 class="ui header">
    <div class="ui secondary menu right floated">
      <a class="active item">문제</a>
      <a class="item">출처</a>
      <a class="item">태그</a>
    </div>

    <i class="book icon"></i>
    <div class="content">
      문제 목록
      <div class="sub header">Problems</div>
    </div>
  </h2>

  <table class="ui striped padded table unstackable">
    <thead>
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Accepts</th>
        <th>Submits</th>
        <th>Rate</th>
      </tr>
    </thead>
    <tbody>
      @foreach($problems as $problem)
      <tr>
        <td>
          {{ $problem->id }}
        </td>
        <td>
          <a href="{{ url('/problems/'.$problem->id) }}">{{ $problem->title }}</a>&nbsp;&nbsp;

          @if( $problem->is_special )
            <a class="ui teal basic label">스페셜 저지</a>
          @endif

          <? if( rand(0,10)==2 ){ ?>
            <a class="ui red basic label">도전 중</a>
          <? } else if( rand(0,10) < 1 ){ ?>
            <a class="ui green basic label">해결</a>
          <? } ?>
        </td>
        <td>
          <a href="/solutions/?problem_id={{ $problem->id }}&result_id=2">
            {{ $problem->getAcceptCount() }}
          </a>
        </td>
        <td>
          <a href="/solutions/?problem_id={{ $problem->id }}">
            {{ $problem->getSubmitCount() }}
          </a>
        </td>
        <td>{{ number_format($problem->getRate(), 2) }} %</td>
      </tr>
      @endforeach
    </tbody>
  </table>

  @include('pagination.default', ['paginator' => $problems])

@stop