
      <div class="ui stackable grid">
        <div class="two wide column field column-label">제목</div>
        <div class="fourteen wide column field">
          {!! Form::text('title', old('title'), ['placeholder' => '게시글 제목']) !!}
        </div>
      </div>
      
      <div class="ui stackable grid">
        <div class="two wide column field column-label">내용</div>
        <div class="fourteen wide column field">
          {!! Form::textarea('content', old('content'), ['id' => 'editor', 'class' => 'html-editor']) !!}
        </div>
      </div>
      
      
      <div class="ui divider"></div>
      
      <div class="ui stackable grid">
        <div class="two wide column field"></div>
        <div class="fourteen wide column field">
          <button type="submit" class="ui primary button">{{ isset($submitButtonText) ? $submitButtonText : "작성하기" }}</button>
        </div>
      </div>
      