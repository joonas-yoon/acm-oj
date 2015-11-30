@extends('master')

@section('content')

  @include('problems.maker.step',
  ['step1' => 'completed', 'step2' => 'completed', 'step3' => 'completed active' ])

  @include('errors.list')

  <div class="segment">
    문제가 생성됬어요 뿌뿌
  </div>

  <div class="ui divider hidden"></div>
  <div class="text-center">
    <a href="#" class="ui green button">문제 보러 가기</a>
  </div>

@stop

@section('script')

@stop