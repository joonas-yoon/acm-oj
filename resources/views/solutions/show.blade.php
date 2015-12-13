@extends('master')

@section('title')
{{ $code->id }}번 소스 코드
@stop

@section('content')
<div class="ui container">
  
    <table class="ui very basic padded table unstackable">
      <thead>
        <tr><th class="center aligned">채점 번호</th>
        <th>제출자</th>
        <th>문제 번호</th>
        <th>결과</th>
        <th>시간</th>
        <th>메모리</th>
        <th>언어</th>
        <th>코드 길이</th>
        <th>제출한 시간</th>
      </tr></thead>
      <tbody style="background-color:#eee;">
        <tr>
          <td class="center aligned">{{ $code->id }}</td>
          <td>
            <a href="/user/{{ $solution->user->name }}">{{ $solution->user->name }}</a>
          </td>
          <td>
            <a class="popup title" href="/problems/{{ $solution->problem->id }}" data-content="{{ $solution->problem->title }}" data-variation="inverted">{{ $solution->problem->id }}</a>
          </td>
          <td>{!! $solution->resultToHtml() !!}</td>
          @if( $solution->result_id == $acceptCode )
          <td>{{ $solution->time }} <span class="solution unit"> MS</span></td>
          <td>{{ $solution->memory }} <span class="solution unit"> KB</span></td>
          @else
          <td></td><td></td>
          @endif
          <td>{{ $solution->language->name }}</td>
          <td>{{ $solution->size }} <span class="solution unit"> B</span></td>
          <td>
            <a class="popup date" data-content="{{ $solution->created_at }}" data-variation="inverted">{{ $solution->created_at->diffForHumans() }}</a>
          </td>
        </tr>
      </tbody>
    </table>
    
    <div class="ui hidden divider"></div>
    
    <div class="ui dividing header">{{ $code->id }}번 소스 코드</div>
    <div id="editor" class="code" data-lang="{{ $solution->language->name }}" data-theme="{{ Sentinel::getUser()->default_code_theme }}">{{ $code->code }}</div>
    
    <div class="ui hidden divider"></div>
    
    @if( Sentinel::getUser()->id == $solution->user_id )
    <div class="ui form">
      <div class="field">
        <div class="ui toggle checkbox">
          <input type="checkbox" name="is_published" tabindex="0" class="hidden" {{ $solution->is_published ? 'checked':'' }}>
          <label>같은 문제를 해결한 사람들에게 이 소스 코드를 공개합니다.</label>
        </div>
      </div>
    </div>
    @endif
    
</div>
@stop

@section('script')
  <script>
    $('.popup').popup();
    $('.ui.checkbox').checkbox();
  </script>
  <script src="/assets/editor/src-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
  <script src="/assets/editor.js" type="text/javascript" charset="utf-8"></script>
  <script>
  $(function(){
    var lang = $('#editor').attr('data-lang');
    var editor = ace.edit('editor');
    initEditor(editor, getLanguageClass(lang), $('#editor').attr('data-theme'));
    editor.setReadOnly(true);
    editor.setOptions({
      minLines: 5,
      maxLines: Infinity
    });
  })
  </script>
@stop