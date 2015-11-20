
    @if ( ! auth()->check() )
    <div class="ui right item">
        <a class="index item" href="/auth/login">로그인</a>&nbsp;|
        <a class="index item" href="/auth/register">회원가입</a>
    </div>
    @else
    <div class="ui right dropdown index item">
        <img class="ui avatar image" src="/images/no-image.png">&nbsp;&nbsp;
        {{ auth()->user()->name }}
        <i class="dropdown icon"></i>
        <div class="menu">
            <a class="item" href="#">설정</a>
            <a class="item" href="/auth/logout">로그 아웃</a>
        </div>
    </div>
    @endif