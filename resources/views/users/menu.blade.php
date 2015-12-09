
    <div class="ui fluid card">
      <div class="content">
        <div class="image rounded rectangle crop right floated">
          <img class="avatar-image portrait photo" alt="User Profile Photo" src="/images/no-image.png">
        </div>
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
      <a class="item active">정보 수정</a>
      <a class="item">비밀번호 변경</a>
      <a class="item">기본 언어 설정</a>
      <a class="item">공개 범위 설정</a>
    </div>