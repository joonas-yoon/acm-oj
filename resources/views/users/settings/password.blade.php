
  {!! Form::model($user, ['method' => 'PATCH', 'class' => 'ui form']) !!}
  {!! csrf_field() !!}
  
    <h3 class="ui dividing header" style="margin-top:0;">비밀번호 변경</h3>
    
    <div class="inline fields">
      <div class="three wide field">
        <label>기존 비밀번호</label>
      </div>
      <div class="field">
        <input type="password" name="old_password" >
      </div>
    </div>
    
    <div class="inline fields">
      <div class="three wide field">
        <label>새로운 비밀번호</label>
      </div>
      <div class="field">
        <input type="password" name="new_password" >
      </div>
    </div>
    
    <div class="inline fields">
      <div class="three wide field">
        <label>새로운 비밀번호 확인</label>
      </div>
      <div class="field">
        <input type="password" name="new_password_confirmation" >
      </div>
    </div>
    
    <div class="field">
      <div class="ui error message"></div>
      @include('errors.list')
    </div>
    
    <div class="ui divider"></div>
    
    <div class="inline fields">
      <div class="three wide field"></div>
      <div class="field">
        {!! Form::submit('수정', ['class' => 'ui blue button']) !!}
      </div>
    </div>
    
  {!! Form::close() !!}
  
  <script>
  $('.ui.form')
    .form({
      fields: {
        password : {
          identifier: 'old_password',
          rules: [
            {
              type   : 'empty',
              prompt : '기존 비밀번호를 입력하세요.'
            }
          ]
        },
        new_password : {
          identifier: 'new_password',
          rules: [
            {
              type   : 'empty',
              prompt : '새로운 비밀번호를 입력하세요.'
            },
            {
              type   : 'different[old_password]',
              prompt : '입력하신 비밀번호는 기존 비밀번호와 같습니다.'
            }
          ]
        },
        confirmation: {
          identifier  : 'new_password_confirmation',
          rules: [
            {
              type   : 'match[new_password]',
              prompt : '변경할 비밀번호가 일치하지 않습니다.'
            }
          ]
        }
      },
      
      inline : true,
      on     : 'blur'
    })
  ;
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