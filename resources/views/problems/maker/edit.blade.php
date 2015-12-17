@extends('master')

@section('title')
문제 수정 - {{ $problem->id }}번
@stop

@section('content')
<div class="ui container">

  @include('problems.maker.step',
    ['step1' => 'active', 'step2' => 'disabled', 'step3' => 'disabled' ])

  @include('errors.list')

  {!! Form::model($problem, ['method' => 'PATCH', 'url' => '/problems/'. $problem->id, 'class' => 'ui form', 'id' => 'problem']) !!}

  @include('problems.maker.form', ['tags' => TagService::getTags($problem->id)])

  <div class="ui divider hidden"></div>

  <div class="ui centered grid">
    {!! Form::submit('수정', ['class' => 'ui blue button']) !!}
  </div>

  {!! Form::close() !!}

</div>
@stop

@section('script')

@stop