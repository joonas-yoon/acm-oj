
  <div class="ui icon message">
    <i class="inbox icon"></i>
    <div class="content">
      <div class="header">클릭하여 세션을 정리하세요!</div>
      <p>아래 목록에서 세션 정보를 확인하실 수 있습니다.</p>
    </div>
  </div>

  <div class="ui divided selection animated sessions list">
  @foreach ($user->persistences as $index => $p)
    @if ($p->code === $persistence->check())
    <div class="item active">
      <i class="large power middle aligned icon"></i>
      <a class="content" href="{{ URL::to("sessions/kill/{$p->code}") }}">
        <div class="header">
          {{ $p->created_at->formatLocalized('%Y년 %m월 %e일') }}
          <div class="description">
            {{ $p->created_at->formatLocalized('%k시 %M분') }}
          </div>
        </div>
      </a>
    </div>
    @else
    <div class="item">
      <i class="large plug middle aligned icon"></i>
      <a class="content" href="{{ URL::to("sessions/kill/{$p->code}") }}">
        <div class="header">
          {{ $p->created_at->formatLocalized('%Y년 %m월 %e일') }}
          <div class="description">
            {{ $p->created_at->formatLocalized('%k시 %M분') }}
          </div>
        </div>
      </a>
    </div>
    @endif
  @endforeach
  </div>
  
  <div class="ui hidden divider"></div>
  
  <div class="ui fluid buttons">
    <a href="{{ URL::to('sessions/kill-all') }}" class="ui button">모두 종료 <small>(현재 세션은 제외합니다.)</small></a>
    <div class="or" data-text="OR"></div>
    <a href="{{ URL::to('sessions/kill') }}" class="ui negative button">모두 종료 <small>(현재 세션도 종료합니다.)</small></a>
  </div>