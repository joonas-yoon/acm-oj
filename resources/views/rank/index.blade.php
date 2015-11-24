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
        <th>이메일</th>
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
          <a href="/user/{{ $user->id }}">{{ $user->name }}</a>
        </td>
        <td>
          <a href="/user/{{ $user->id }}">{{ $user->email }}</a>
        </td>
        <td>
          <a href="/solutions/?user_id={{ $user->id }}&result_id={{ \App\Result::getAcceptCode() }}">{{ $user->getAcceptCount() }}</a>
        </td>
        <td>
          <a href="/solutions/?user_id={{ $user->id }}">{{ $user->getSubmitCount() }}</a>
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