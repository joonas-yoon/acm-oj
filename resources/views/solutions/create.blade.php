@extends('master')

@section('title')
{{ $problem->id }}번 제출
@stop

@section('content')
<div class="ui container">

  @include('problems.nav', ['problem_id' => $problem->id] )

  <h2 class="ui dividing header">{{ $problem->title }}</h2>

  {!! Form::open(['url' => action('SolutionsController@store'), 'class' => 'ui form submit']) !!}

  <div class="ui stackable grid">
    <div class="two wide column field column-label">언어</div>
    <div class="fourteen wide column field">
      {!! Form::select('lang_id', $languages, old('lang_id', $defaults['language'] ? $defaults['language'] : 2), ['class' => 'ui search selection dropdown']) !!}
    </div>
  </div>

  <div class="ui stackable grid">
    <div class="two wide column field column-label">공개 범위</div>
    <div class="fourteen wide column">
      <div class="ui toggle checkbox">
        <input type="checkbox" name="is_published" tabindex="0" class="hidden" {{ old('is_published', 1) == 1 ? 'checked':'' }}>
        <label>소스 코드 공개</label>
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
      <div id="editor" class="code" data-theme="{{ $defaults['code_theme'] }}">{{ old('code') }}</div>
      <div class="ui divider hidden"></div>
      {!! Form::submit('제출', ['class' => 'ui blue button']) !!}
    </div>
  </div>

  {!! Form::textarea('code', '', ['style'=>'display:none;']) !!}
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
  $('.ui.checkbox').checkbox();
  $('select.dropdown').dropdown();
  </script>
  
  <script src="/assets/editor/src-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
  <script src="/assets/editor.js" type="text/javascript" charset="utf-8"></script>
  <script>
  $(function(){
    var langSel = $('select[name=lang_id]');
    var selected = function(sel){ return sel.find('option')[sel.val()].text; };
    var editor = ace.edit('editor');
    initEditor(editor, getLanguageClass(selected(langSel)), $('#editor').attr('data-theme'));
    langSel.on('change', function(){
      editor.session.setMode( 'ace/mode/' + getLanguageClass(selected(langSel)) );
    });
    $('form.submit').on('submit', function(){
      $('textarea[name=code]').val(editor.getValue());
    });
  })
  </script>
@stop