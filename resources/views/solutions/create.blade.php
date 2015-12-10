@extends('master')

@section('title')
{{ $problem->id }}번 제출
@stop

@section('content')
<div class="ui container">

  <div class="ui breadcrumb" style="padding-bottom:1em;">
    <a class="section" href="/problems">문제 목록</a>
    <i class="right chevron icon divider"></i>
    <a class="section" href="/problems/{{ $problem->id }}">{{ $problem->id }}번</a>
    <i class="right chevron icon divider"></i>
    <div class="active section">Submit</div>
  </div>

  <h2 class="ui dividing header">{{ $problem->title }}</h2>

  {!! Form::open(['url' => action('SolutionsController@index'), 'class' => 'ui form submit']) !!}

  <div class="ui stackable grid">
    <div class="two wide column field column-label">언어</div>
    <div class="fourteen wide column field">
      {!! Form::select('lang_id', ['선택하세요', 'C', 'C++'], Input::old('lang_id') ? Input::old('lang_id') : 2, ['class' => 'ui search selection dropdown']) !!}
    </div>
  </div>

  <div class="ui stackable grid">
    <div class="two wide column field column-label">공개 범위</div>
    <div class="fourteen wide column">
      <div class="inline fields">
        <div class="field">
          <div class="ui radio checkbox">
            {!! Form::radio('is_published', 0, 0 == Input::old('is_published'), ['class'=>'hidden']) !!}
            <label>공개</label>
          </div>
        </div>
        <div class="field">
          <div class="ui radio checkbox">
            {!! Form::radio('is_published', 1, 1 == Input::old('is_published'), ['class'=>'hidden']) !!}
            <label>정답인 경우만 공개</label>
          </div>
        </div>
        <div class="field">
          <div class="ui radio checkbox">
            {!! Form::radio('is_published', 2, 2 == Input::old('is_published'), ['class'=>'hidden']) !!}
            <label>비공개</label>
          </div>
        </div>
      </div>
    </div>
  </div>

  @if (count($errors) > 0)
  
    <div class="ui stackable grid">
      <div class="two wide column field column-label">오류</div>
      <div class="fourteen wide column field">
        <div class="ui visible warning message">
            <div class="header">
                Sorry, please correct them below.
            </div>
            <ul class="ui list">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
      </div>
    </div>
  
  @endif

  <div class="ui stackable grid">
    <div class="two wide column field column-label">소스 코드</div>
    <div class="fourteen wide column field inline">
      {!! Form::textarea('code') !!}
      <div class="ui divider hidden"></div>
      {!! Form::submit('제출', ['class' => 'ui blue button']) !!}
    </div>
  </div>

  {!! Form::hidden('problem_id', $problem->id) !!}
  {!! Form::close() !!}

</div>
@stop

@section('script')
  <script>
  $('.ui.rating')
    .rating({
      initialRating: 2,
      maxRating: 5
    })
  ;
  $('.ui.radio.checkbox')
    .checkbox()
  ;
  $('select.dropdown')
    .dropdown()
  ;
  </script>
@stop