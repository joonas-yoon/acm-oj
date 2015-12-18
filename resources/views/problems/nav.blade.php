
  <div class="ui top attached tabular menu">
    @if( if_route(['problems.show', 'problems.submit', 'problems.preview']) || if_query('problem_id', true) )
      <a class="item {{ active_class( if_uri_start(['problems']) ) }}" href="/problems/{{ $problem_id }}">{{ $problem_id }}번</a>
      @if( ProblemService::getProblem($problem_id)->status == 1 )
      <a class="item {{ active_class( if_uri_start(['submit']) ) }}" href="/submit/{{ $problem_id }}">제출하기</a>
      @endif
      @if( Sentinel::check() )
        <a class="item {{ active_class( if_route(['solutions.index']) && ! if_query('user', Sentinel::getUser()->name) ) }}" href="/solutions/?from=problem&problem_id={{ $problem_id }}">채점 현황</a>
        <a class="item {{ active_class( if_query('user', Sentinel::getUser()->name) ) }}" href="/solutions/?from=problem&problem_id={{ $problem_id }}&user={{ Sentinel::getUser()->name }}">내 채점</a>
      @else
        <a class="item {{ active_class( if_route(['solutions.index']) ) }}" href="/solutions/?from=problem&problem_id={{ $problem_id }}">채점 현황</a>
      @endif
      <a class="item" href="/problems">문제 목록</a>
    @else
      <a class="item {{ active_class( if_route(['problems.index']) ) }}" href="/problems">문제 목록</a>
      <a class="item {{ active_class( if_route(['problems.index.new']) ) }}" href="/problems/new">새로 추가된 문제</a>
      <a class="item">출처</a>
      <a class="item {{ active_class( if_route(['tags.index']) ) }}" href="/tags">태그</a>
      @if( if_route(['tags.show', 'tags.problems']) )
        <a class="item active" href="/tags/{{ $tag['id'] }}">{{ $tag['name'] }}</a>
      @endif
      <a class="item {{ active_class( if_route(['problems.create.list']) ) }}" href="/problems/create/list">문제 제작</a>
    @endif
  </div>
