
  {!! Form::model($user, ['method' => 'PATCH', 'class' => 'ui form']) !!}
  {!! csrf_field() !!}
  
    <h3 class="ui dividing header" style="margin-top:0;">정보 수정</h3>
    
    <div class="inline fields">
      <div class="three wide field">
        <label>아이디</label>
      </div>
      <div class="field">
        <input type="text" value="{{ $user->name }}" disabled>
      </div>
    </div>
    
    <div class="inline fields">
      <div class="three wide field">
        <label>이메일</label>
      </div>
      <div class="ten wide field">
        <input type="text" value="{{ $user->email }}" disabled>
      </div>
      <div class="three wide field">
        <div class="ui slider checkbox">
          <input type="checkbox" tabindex="0" class="hidden" name="email_open" {{ old('email_open', $user->email_open) ? 'checked' : '' }}>
          <label for="email_open">공개</label>
        </div>
      </div>
    </div>
    
    <div class="inline fields">
      <div class="three wide field">
        <label>한마디</label>
      </div>
      <div class="thirteen wide field">
        <input type="text" name="via" placeholder="한마디" value="{{ $user->via }}">
      </div>
    </div>
    
    <div class="ui hidden divider"></div>
    
    <div class="ui accordion field">
      <div class="title">
        <i class="icon dropdown"></i>
        자세한 정보
      </div>
      <div class="content">
        <div class="inline fields">
          <div class="three wide field">
            <label>이름</label>
          </div>
          <div class="field">
            <input type="text" name="last_name" placeholder="성" value="{{ $user->last_name }}">
          </div>
          <div class="field">
            <input type="text" name="first_name" placeholder="이름" value="{{ $user->first_name }}">
          </div>
        </div>
        <div class="inline fields">
          <div class="three wide field">
            <label>소속</label>
          </div>
          <div class="thirteen wide field">
            <input type="text" name="organization" placeholder="회사 또는 학교, 팀 등" value="{{ $user->organization }}">
          </div>
        </div>
      </div>
    </div>
    
    <div class="ui hidden divider"></div>
    
    <div class="inline fields">
      <div class="three wide field">
        <label>비밀번호 확인</label>
      </div>
      <div class="field">
        <input type="password" name="password" placeholder="현재 비밀번호">
      </div>
    </div>
    
    <div class="field">
      <div class="ui error message"></div>
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
          identifier: 'password',
          rules: [
            {
              type   : 'empty',
              prompt : '비밀번호를 입력하세요.'
            }
          ]
        },
      }
    })
  ;
  $('.ui.checkbox').checkbox();
  $('.ui.accordion.field').accordion();
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