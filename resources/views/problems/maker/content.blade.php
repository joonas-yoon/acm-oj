@extends('master')

@section('content')

  @include('problems.maker.step',
    ['step1' => 'active', 'step2' => 'disabled', 'step3' => 'disabled' ])

  @include('errors.list')

  {!! Form::open(['url' => '/problems/create/data', 'class' => 'ui form', 'id' => 'problem']) !!}

  <div class="ui centered grid">
    <div class="field ten wide column">
      <label>문제 제목</label>
      <div class="ui corner labeled input">
        {!! Form::text('title', old('title', '')) !!}
        <div class="ui right corner label"><i class="asterisk icon"></i></div>
      </div>
    </div>
  </div>

  <div class="ui centered stackable grid">
    <div class="field">
      <label>시간 제한</label>
      <div class="ui right labeled input">
        {!! Form::text('time_limit', old('time_limit', 1), ['class'=>'text-right']) !!}
        <div class="ui basic label">초</div>
      </div>
    </div>
    <div class="field">
      <label>메모리 제한</label>
      <div class="ui right labeled input">
        {!! Form::text('memory_limit', old('memory_limit', 128), ['class'=>'text-right']) !!}
      <div class="ui basic label">MB</div>
      </div>
    </div>
    <div class="field">
      <label>태그</label>
      <select multiple="" class="ui search multiple dropdown">
        <option value=""></option>
        <option value="TAG1">tag1</option><option value="TAG2">tag2</option>
        <option value="TAG3">Another tag</option><option value="TAG4">Other tag</option>

        <option value="TAGA">tag3</option><option value="TAGH">tag4</option>
        <option value="TAGB">tag5</option><option value="TAGG">tag6</option>
        <option value="TAGC">tag7</option><option value="TAGF">tag8</option>
        <option value="TAGD">tag9</option><option value="TAGE">tag0</option>
      </select>
    </div>
  </div>

  <div class="ui horizontal divider"><i class="pencil icon"></i>&nbsp;&nbsp;문제 설명</div>
  {!! Form::textarea('description', old('description')) !!}

  <div class="ui horizontal divider">입력 형식</div>
  {!! Form::textarea('input', old('input')) !!}

  <div class="ui horizontal divider">출력 형식</div>
  {!! Form::textarea('output', old('output')) !!}

  <div class="ui horizontal divider">예제</div>
  <div class="ui stackable grid">
    <div class="eight wide column">
      <div class="ui segment code">
        <div class="ui top attached label">입력</div>
          {!! Form::textarea('sample_input', old('sample_input')) !!}
      </div>
    </div>
    <div class="eight wide column">
      <div class="ui segment code">
        <div class="ui top attached label">출력</div>
          {!! Form::textarea('sample_output', old('sample_output')) !!}
      </div>
    </div>
  </div>

  <div class="ui horizontal divider">Hint</div>
  {!! Form::textarea('hint', old('hint')) !!}

  <div class="ui horizontal divider"><i class="heart icon"></i>&nbsp;Thanks to</div>
  <div class="context">
    <div class="ui label">
      번역
      <a class="detail">@author1 @author2</a>
    </div>
    <div class="ui label">
      오타
      <a class="detail">@author3</a>
    </div>
  </div>

  <div class="ui divider hidden"></div>

  <div class="ui centered grid">
    {!! Form::button('미리보기', ['class' => 'ui green button preview', 'action' => '/problems/create/preview']) !!}
    {!! Form::submit('다음 단계', ['class' => 'ui blue button']) !!}
  </div>

  {!! Form::close() !!}

@stop

@section('script')
  <script>
  $('.ui.dropdown').dropdown();
  $('button.preview')
    .on('click', function(){
      var form = $('form').has($(this));
      form.attr('action', $(this).attr('action'));
      form.submit();
    })
  ;
  </script>
@stop