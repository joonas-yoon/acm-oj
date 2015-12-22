@extends('admins.layouts.master')

@section('title')
  관리자 - 재채점
@stop

@section('pre-content')
<h1 class="ui header">
  재채점
</h1>
<div class="sub header">
  이미 채점된 코드를 다시 채점합니다.
</div>
@stop

@section('content')

    @include('errors.session')

    <div class="ui icon warning message">
      <div class="icon">
        <i class="warning sign icon"></i>
      </div>
      <div class="content">
        <div class="header">주의하세요.</div>
        <p>
          기존의 채점 결과가 갱신되오니 사용에 주의하여 주세요.
        </p>

        <form method="POST" action="{{ action('AdminController@processRejudge') }}">
        {!! csrf_field() !!}
        <div class="ui right action left icon input">
          <i class="wizard icon"></i>
          <input type="text" name="problem_id" placeholder="문제 번호">
          <button type="submit" class="ui red button">재채점하기</button>
        </div>
        </form>
      </div>
    </div>
@stop

@section('script')

@stop