
    @if ( \Auth::user() == null )
    <div class="ui right item">
        <a class="item" href="/auth/login">로그인</a>&nbsp;|
        <a class="item" href="/auth/register">회원가입</a>
    </div>
    @else
    <div class="ui right dropdown item">
        <img class="ui avatar image" src="/images/no-image.png">&nbsp;&nbsp;
        {{ \Auth::user()->name }}
        <i class="dropdown icon"></i>
        <div class="menu">
            <a class="item" href="#">설정</a>
            <a class="item" href="/auth/logout">로그 아웃</a>
        </div>
    </div>
    @endif