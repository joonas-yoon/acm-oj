@extends('master')

@section('content')
<div class="ui container">
  
  @include('problems.maker.step',
  ['step1' => 'completed', 'step2' => 'completed', 'step3' => 'completed active' ])

  @include('errors.list')

  <div class="ui divider hidden"></div>
  <div class="text-center">
    <a href="/problems/create/list" class="ui green button">목록으로</a>
  </div>

</div>
@stop

@section('script')

@stop