
  <div class="ui top attached tabular menu">
    @if( isset($options) && isset($options['problem_id']) )
      <a class="item {{ \App\Helpers::setActive('problems') }}" href="/problems/{{ $options['problem_id'] }}">{{ $options['problem_id'] }}번</a>
      <a class="item {{ \App\Helpers::setActiveStrict('problems') }}" href="/problems">문제 목록</a>
      <a class="item {{ \App\Helpers::setActive('solutions') }}" href="/solutions/?from=problem&problem_id={{ $options['problem_id'] }}">채점 현황</a>
    @else
      <a class="item {{ \App\Helpers::setActiveStrict('problems') }}" href="/problems">문제 목록</a>
      <a class="item {{ \App\Helpers::setActive('problems/new') }}" href="/problems/new">새로 추가된 문제</a>
      <a class="item">출처별</a>
      @if( isset($options) && isset($options['tag']) )
        <a class="item active" href="/problems/tag/{{ $options['tag']['id'] }}">{{ $options['tag']['name'] }}</a>
      @else
        <a class="item {{ \App\Helpers::setActive('tags') }}" href="/tags">태그별</a>
      @endif
      <a class="item {{ \App\Helpers::setActive('problems/create') }}" href="/problems/create/list">문제 제작</a>
    @endif
  </div>
