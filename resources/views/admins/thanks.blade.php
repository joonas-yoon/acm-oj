@extends('admins.layouts.master')

@section('title')
    관리자 페이지
@stop

@section('pre-content')
<h1 class="ui header">
  추가 정보 관리
</h1>
<div class="sub header">
  문제와 연결된 추가 정보를 관리합니다.
</div>
@stop

@section('content')
  <table class="ui celled striped table">
    <thead>
      <th></th>
      <th>정보</th>
    </thead>
    <tbody>
    @foreach( $allThanks as $thank )
    <tr>
      <td>{{ $thank->id }}</td>
      <td>{{ $thank->name }}</td>
    </tr>
    @endforeach
    </tbody>
  </table>
@stop

@section('script')

@stop