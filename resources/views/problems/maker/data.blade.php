@extends('master')

@section('content')

  @include('problems.maker.step',
  ['step1' => '', 'step2' => '', 'step3' => 'disabled' ])

  @include('errors.list')

  {!! Form::open(array('url'=>'apply/upload','method'=>'POST', 'files'=>true, 'class'=>'ui form')) !!}

  <div class="field">
    <div class="two fields">
      <div class="field">
        <label for="input.1">입력 데이터 #1</label>
        <input type="file" class="ui button" value="입력 데이터" name="input.1" />
      </div>
      <div class="field">
        <label for="output.1">출력 데이터 #1</label>
        <input type="file" class="ui button" value="출력 데이터" name="output.1" />
      </div>
    </div>
  </div>

  <div class="ui divider"></div>
  <div class="text-center">
    {!! Form::submit('등록하기', ['class' => 'ui blue button']) !!}
  </div>

  {!! Form::close() !!}

@stop

@section('script')

@stop