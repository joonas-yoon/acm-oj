
  <div class="ui top attached tabular menu">
    @if( isset($problem_id) )
      <a class="item {{ \App\Helpers::setActive('problems') }}" href="/problems/{{ $problem_id }}">{{ $problem_id }}번</a>
      <a class="item {{ \App\Helpers::setActive('submit') }}" href="/submit/{{ $problem_id }}">제출하기</a>
      @if( Sentinel::check() )
        @if( isset($username) && Sentinel::getUser()->name == $username )
        <a class="item" href="/solutions/?from=problem&problem_id={{ $problem_id }}">채점 현황</a>
        <a class="item {{ \App\Helpers::setActive('solutions') }}" href="/solutions/?from=problem&problem_id={{ $problem_id }}&user={{ Sentinel::getUser()->name }}">내 소스</a>
        @else
        <a class="item {{ \App\Helpers::setActive('solutions') }}" href="/solutions/?from=problem&problem_id={{ $problem_id }}">채점 현황</a>
        <a class="item" href="/solutions/?from=problem&problem_id={{ $problem_id }}&user={{ Sentinel::getUser()->name }}">내 소스</a>
        @endif
      @else
        <a class="item {{ \App\Helpers::setActive('solutions') }}" href="/solutions/?from=problem&problem_id={{ $problem_id }}">채점 현황</a>
      @endif
      <a class="item {{ \App\Helpers::setActiveStrict('problems') }}" href="/problems">문제 목록</a>
    @else
      <a class="item {{ \App\Helpers::setActiveStrict('problems') }}" href="/problems">문제 목록</a>
      <a class="item {{ \App\Helpers::setActive('problems/new') }}" href="/problems/new">새로 추가된 문제</a>
      <a class="item">출처</a>
      @if( isset($tag) )
        <a class="item" href="/tags">태그</a>
        <a class="item active" href="/tags/{{ $tag['id'] }}/problems">{{ $tag['name'] }}</a>
      @else
        <a class="item {{ \App\Helpers::setActive('tags') }}" href="/tags">태그</a>
      @endif
      <a class="item {{ \App\Helpers::setActive('problems/create') }}" href="/problems/create/list">문제 제작</a>
    @endif
  </div>
