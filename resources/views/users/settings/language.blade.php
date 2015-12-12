
  {!! Form::model($user, ['method' => 'PATCH', 'class' => 'ui form']) !!}
  {!! csrf_field() !!}
  
    <h3 class="ui dividing header" style="margin-top:0;">기본 언어 및 테마 설정</h3>
    
    <div class="inline fields">
      <div class="three wide field">
        <label>기본 언어</label>
      </div>
      <div class="field">
        <select class="ui search selection dropdown" name="default_language" value="{{ $defaults['language'] }}">
          <option value="0">없음</option>
          @foreach($langs as $option)
          <option value="{{ $option->id }}" {{ $option->id == $defaults['language'] ? 'selected':'' }}>{{ $option->name }}</option>
          @endforeach
        </select>
      </div>
    </div>
    
    <div class="inline fields">
      <div class="three wide field">
        <label>기본 테마 설정</label>
      </div>
      <div class="field">
        <select class="ui search selection dropdown" name="default_code_theme" value="{{ $defaults['code_theme'] }}">
          @foreach( $themes as $theme )
          <option value="{{ $theme['value'] }}" {{ $theme['value'] == $defaults['code_theme'] ? 'selected':'' }}>{{ $theme['name'] }}</option>
          @endforeach
        </select>
      </div>
    </div>
    
    <div class="field">
      @if (Session::has('error') )
      <div class="ui red message">
          <i class="warning icon"></i>&nbsp;{!! session('error') !!}
      </div>
      @endif
      @if (Session::has('success') )
      <div class="ui green message">
          <i class="checkmark icon"></i>&nbsp;{!! session('success') !!}
      </div>
      @endif
    </div>
    
    <div id="editor" class="code">//C hello world example
#include <stdio.h>
 
int main(void)
{
  printf("Hello world\n");
  return 0;
}

// Java hello world example
class HelloWorld
{
   public static void main(String args[])
   {
      System.out.println("Hello World");
   }
}</div>

    <div class="ui divider"></div>
    
    <div class="inline fields">
      <div class="three wide field"></div>
      <div class="field">
        {!! Form::submit('수정', ['class' => 'ui blue button']) !!}
      </div>
    </div>
    
  {!! Form::close() !!}
  
  <script>
  $('.ui.dropdown').dropdown();
  $('.message.green')
    .visibility({
      onRefresh: function(){
        $(this).transition({
          animation: 'fade',
          interval: 2000
        });
      }
    })
  ;
  </script>
  
  <script src="/assets/editor/src-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
  <script src="/assets/editor.js" type="text/javascript" charset="utf-8"></script>
  <script>
  $(function(){
    var langSel  = $('select[name=default_language]');
    var themeSel = $('select[name=default_code_theme]');
    var selected = function(sel){ return sel.find('option')[sel.val()].text; };
    var editor = ace.edit('editor');
    initEditor(editor, getLanguageClass(selected(langSel)), themeSel.val());
    langSel.on('change', function(){
      editor.session.setMode( 'ace/mode/' + getLanguageClass(selected(langSel)) );
    });
    themeSel.on('change', function(){
      editor.setTheme('ace/theme/' + $(this).val() );
    });
    editor.setOptions({
        minLines: 20, maxLines: 20
    })
  })
  </script>