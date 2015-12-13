@extends('master')

@section('title')랭킹 - {{ $paginator->currentPage() }} 페이지@stop
@section('content')
<div class="ui container">

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
        <td>{{ $rankNumber++ }}</td>
        <td>
          <a href="/user/{{ $user->name }}"><img class="ui avatar image" src="{{ $user->photo_link }}">&nbsp;{{ $user->name }}</a>
        </td>
        <td>
          {{ $user->via }}
        </td>
        <td>
          <a href="/solutions/?user={{ $user->name }}&result_id={{ \App\Models\Result::acceptCode }}">{{ $user->getAcceptCount() }}</a>
        </td>
        <td>
          <a href="/solutions/?user={{ $user->name }}">{{ $user->getSubmitCount() }}</a>
        </td>
        <td>{{ number_format($user->getTotalRate(), 2) }} %</td>
      </tr>
    @endforeach
    </tbody>
  </table>

  @include('pagination.default', ['paginator' => $paginator])

</div>
@stop

@section('script')

@stop