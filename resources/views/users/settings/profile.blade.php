
  {!! Form::model($user, ['method' => 'PATCH', 'class' => 'ui form']) !!}
  
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
      <div class="field">
        <input type="text" value="{{ $user->email }}" disabled>
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
    
    <div class="inline fields">
      <div class="three wide field">
        <label>비밀번호 확인</label>
      </div>
      <div class="field">
        <input type="password" name="password" placeholder="현재 비밀번호">
      </div>
    </div>
    
    <div class="field">
      @include('errors.list')
      <div class="ui error message"></div>
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
  </script>