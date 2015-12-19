
  <div class="ui centered grid">
    <div class="field ten wide column">
      <label>문제 제목</label>
      <div class="ui corner labeled input">
        {!! Form::text('title', old('title')) !!}
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
    <div class="tags field">
      <label>태그 <i class="circle help popup icon" data-title="알고리즘을 선택하세요." data-content="요청된 태그는 관리자 승인 후 등록됩니다."></i></label>
      <select name="tags[]" multiple="" class="ui search multiple tags dropdown">
        <option value="">태그 추가하기</option>
        @foreach( App\Models\Tag::getOpenTags()->get() as $tag )
        <option value="{{ $tag->name }}">{{ $tag->name }}</option>
        @endforeach
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
  
  <script>
  $('.ui.tags.dropdown')
    .dropdown({
      allowAdditions: true,
      maxSelections: 3,
      message: {
        addResult     : '새로운 태그 요청: <b>{term}</b>',
        count         : '선택한 항목 {count} 개',
        maxSelections : '최대 {maxCount}개 까지 등록할 수 있습니다.',
        noResults     : '일치하는 결과가 없습니다.'
      }
    })
    .dropdown('set selected',[
      // $tags를 이 사람이 선택한 태그로 수정해야함.
      @foreach( (isset($problem) ? TagService::getTagsByUser($problem->id) : []) as $tag )
        '{{ $tag->name }}',
      @endforeach
    ])
  ;
  $('.help.icon.popup').popup();
  </script>