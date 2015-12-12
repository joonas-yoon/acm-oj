
    <div class="ui fluid card">
      <div class="blurring dimmable user image">
        <div class="ui dimmer">
          <div class="content">
            <div class="center">
              <div class="ui inverted button">사진 변경</div>
            </div>
          </div>
        </div>
        <img alt="User Profile Photo" src="{{ $user->photo_link }}">
      </div>
      <div class="ui attached add profile button" style="display:none;">
        <i class="photo icon"></i>
        저장하기
      </div>
      <div class="content">
        <div class="header">{{ $user->name }}</div>
        <div class="meta">
          <a class="group">
            {{ $user->email }} <br/>
            {{ $user->organization }}
          </a>
        </div>
        <div class="description" style="padding-top:0.5rem;">
          {{ $user->via ? $user->via : '인사말이 없습니다.' }}
        </div>
      </div>
    </div>
    
    <div class="ui vertical fluid menu">
      <a href="/settings" class="item {{ \App\Helpers::setActiveStrict('settings') }}">정보 수정</a>
      <a href="/password/change" class="item {{ \App\Helpers::setActive('password') }}">비밀번호 변경</a>
      <a href="/settings/language" class="item {{ \App\Helpers::setActive('settings/language') }}">기본 언어 및 테마 설정</a>
      <a href="/settings/privacy" class="item {{ \App\Helpers::setActive('settings/privacy') }}">공개 범위 설정</a>
    </div>
    
    {!! Form::open(array('name'=>'fPhoto', 'url'=>'/upload/photo', 'files'=>true, 'style'=>'display:none;')) !!}
      {!! Form::file('image', ['name'=>'user_photo', 'accept'=>'image/*']) !!}
    {!! Form::close() !!}
    
    <script>
    $('.blurring.dimmable.user.image')
      .dimmer({on: 'hover'})
      .on('click', function(){
        $('input[name=user_photo]').click();
        $('.add.profile.button')
          .on('click', function(){
            $('.user.image .content').html('<div class="ui indeterminate text loader">업로드 중..</div>');
            $('.user.image').dimmer('show');
            $(this).addClass('disabled');
            $('form[name=fPhoto]').submit();
          })
          .transition('show')
        ;
      })
    ;
    </script>