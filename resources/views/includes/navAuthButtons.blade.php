
  @if ( ! Sentinel::check() )
  <div class="ui right index item">
    <div class="ui breadcrumb">
      <a class="section" href="/login/?url={{ Input::get('url', \Request::path()) }}">로그인</a>
      <span class="divider">/</span>
      <a class="section" href="/register">회원가입</a>
    </div>
  </div>
  @else
  <div class="ui right dropdown item">
    <img class="ui avatar image" src="{{ Sentinel::getUser()->photo_link }}">&nbsp;&nbsp;
    {{ Sentinel::getUser()->name }}
    <i class="dropdown icon"></i>
    <div class="menu">
      <a class="item" href="/user/{{ Sentinel::getUser()->name }}">내 정보</a>
      <a class="item" href="/settings">설정</a>
      <div class="ui divider"></div>
      <a class="item" href="/logout">로그 아웃</a>
      @if( is_admin() )
      <div class="ui divider"></div>
      <a href="/admin" class="item">
          <i class="wrench icon"></i> 관리자
      </a>
      @endif
    </div>
  </div>
  @endif