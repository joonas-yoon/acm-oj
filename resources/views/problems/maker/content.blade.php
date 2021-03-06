@extends('master')

@section('title')
문제 제작 - 내용 작성하기
@stop

@section('content')
<div class="ui container">

  @include('problems.maker.step',
    ['step1' => 'active', 'step2' => 'disabled', 'step3' => 'disabled' ])

  @include('errors.list')

  {!! Form::open(['url' => '/problems/create/', 'class' => 'ui form', 'id' => 'problem']) !!}

  @include('problems.maker.form')

  <div class="ui divider hidden"></div>

  <div class="ui centered grid">
    {!! Form::submit('다음 단계', ['class' => 'ui blue button']) !!}
  </div>

  {!! Form::close() !!}

</div>
@stop

@section('script')

  @include('includes.editor-script')
  
@stop