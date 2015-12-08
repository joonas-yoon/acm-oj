@extends('master')

@section('content')
<div class="ui container">

  @include('problems.maker.step',
  ['step1' => 'completed', 'step2' => 'active', 'step3' => 'disabled' ])

  @include('errors.list')

  {!! Form::open(array('url'=>'/problems/create/data', 'method'=>'POST', 'files'=>true, 'class'=>'ui form')) !!}
  {!! Form::hidden('problem', $problem_id) !!}

  <div class="segment">
    <div class="ui red message">
      <p><i class="icon warning"></i> &nbsp; <strong>조심하세요!</strong> 기존에 있던 데이터는 <strong>전부 삭제</strong>됩니다.</p>
    </div>
    <div class="ui hidden divider"></div>
    {!! Form::file('dataFiles[]', ['multiple', 'accept'=>'.in,.out'] ) !!}
  </div>

  <div class="ui divider"></div>
  <div class="text-center">
    {!! Form::submit('데이터 추가하기', ['class' => 'ui blue button']) !!}
    <a href="/problems/create/list" class="ui green button">나중에 하기</a>
    <a href="/problems/preview/{{ $problem_id }}" class="ui button">문제 보러가기</a>
  </div>

  {!! Form::close() !!}

</div>
@stop

@section('script')

@stop