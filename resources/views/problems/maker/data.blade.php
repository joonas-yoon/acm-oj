@extends('master')

@section('content')

  @include('problems.maker.step',
  ['step1' => 'completed', 'step2' => 'active', 'step3' => 'disabled' ])

  @include('errors.list')

  {!! Form::open(array('url'=>'apply/upload', 'method'=>'POST', 'files'=>true, 'class'=>'ui form')) !!}

  <div class="segment">
    {!! Form::file('dataFiles[]', ['multiple', 'accept'=>'.in,.out'] ) !!}
  </div>

  <div class="ui divider"></div>
  <div class="text-center">
    {!! Form::submit('등록하기', ['class' => 'ui blue button']) !!}
  </div>

  {!! Form::close() !!}

@stop

@section('script')

@stop