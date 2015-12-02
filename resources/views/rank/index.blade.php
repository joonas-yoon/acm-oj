@extends('master')

@section('content')

  <h2 class="ui header">
    <i class="trophy icon"></i>
    <div class="content">
      랭킹
      <div class="sub header">Rank</div>
    </div>
  </h2>

  <table class="ui striped red table compact unstackable">
    <thead>
      <tr>
        <th>순위</th>
        <th>이름</th>
        <th>한마디</th>
        <th>해결 수</th>
        <th>제출 수</th>
        <th>비율</th>
      </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
      <tr>
        <td></td>
        <td>
          <a href="/user/{{ $user->name }}">{{ $user->name }}</a>
        </td>
        <td>
          {{-- $user->message --}}
        </td>
        <td>
          <a href="/solutions/?user={{ $user->name }}&result_id={{ \App\Result::getAcceptCode() }}">{{ $user->getAcceptCount() }}</a>
        </td>
        <td>
          <a href="/solutions/?user={{ $user->name }}">{{ $user->getSubmitCount() }}</a>
        </td>
        <td>{{ number_format($user->getRate(), 2) }} %</td>
      </tr>
    @endforeach
    </tbody>
  </table>

  @include('pagination.default', ['paginator' => $users])

@stop

@section('script')

@stop