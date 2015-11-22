@extends('master')

@section('content')

  <div class="ui breadcrumb" style="padding-bottom:1em;">
    <a class="section" href="/problems">Problems</a>
    <i class="right chevron icon divider"></i>
    <a class="section" href="/problems/{{ $problem->id }}">{{ $problem->id }}. {{ $problem->title }}</a>
    <i class="right chevron icon divider"></i>
    <div class="active section">Submit</div>
  </div>

  <h2 class="ui dividing header">{{ $problem->title }}</h2>

  {!! Form::open(['url' => action('SolutionsController@index'), 'class' => 'ui form submit']) !!}

  <div class="ui stackable grid">
    <div class="two wide column field column-label">언어</div>
    <div class="fourteen wide column field">
      <select class="ui search selection dropdown">
        <option value="">선택하세요</option>
        <option value="0">C</option>
        <option value="1">C++</option>
      </select>
    </div>
  </div>

  <div class="ui stackable grid">
    <div class="two wide column field column-label">공개 범위</div>
    <div class="fourteen wide column">
      <div class="inline fields">
        <div class="field">
          <div class="ui radio checkbox">
            <input type="radio" name="published" tabindex="0" class="hidden" checked>
            <label>공개</label>
          </div>
        </div>
        <div class="field">
          <div class="ui radio checkbox">
            <input type="radio" name="published" tabindex="0" class="hidden">
            <label>정답인 경우만 공개</label>
          </div>
        </div>
        <div class="field">
          <div class="ui radio checkbox">
            <input type="radio" name="published" tabindex="0" class="hidden">
            <label>비공개</label>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="ui stackable grid">
    <div class="two wide column field column-label">소스 코드</div>
    <div class="fourteen wide column field inline">
      {!! Form::textarea('code') !!}
      <div class="ui divider hidden"></div>
      {!! Form::submit('제출', ['class' => 'ui blue button']) !!}
    </div>
  </div>

  {!! Form::close() !!}

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