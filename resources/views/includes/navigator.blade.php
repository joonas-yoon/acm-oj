
<!-- Navigator -->
<div class="nav" id="navigator">

@if ( isset($isIndex) )
  <!-- Index Page Navigator -->

  <div class="ui text menu fixed">
    <div class="ui container">
      <a class="browse index item button">
        Menu
        <i class="dropdown icon"></i>
      </a>
      @include('includes.navAuthButtons')
      <div class="ui fluid flowing basic admission popup">
        <div class="ui four column relaxed equal height divided grid">
          <div class="column">
            <h4 class="ui header">문제</h4>
            <div class="ui link list">
              <a class="item" href="{{ action('ProblemsController@index') }}">목록 보기</a>
              <a class="item">문제 분류</a>
              <a class="item">문제 생성</a>
              <a class="item">번역하기</a>
            </div>
          </div>
          <div class="column">
            <h4 class="ui header">채점 현황</h4>
            <div class="ui link list">
              <a class="item">채점 현황</a>
              <a class="item">통계</a>
            </div>
          </div>
          <div class="column">
            <h4 class="ui header">대회</h4>
            <div class="ui link list">
              <a class="item">대회 신청</a>
              <a class="item">대회 목록</a>
              <a class="item">대회 기록</a>
            </div>
          </div>
          <div class="column">
            <h4 class="ui header">커뮤니티</h4>
            <div class="ui link list">
              <a class="item" href="{{ action('RankController@index') }}">랭킹</a>
              <a class="item" href="{{ action('ArticlesController@index') }}">게시판</a>
              <a class="item">팀</a>
              <a class="item">위키</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="nav trigger"></div>

  <script>
  $('.browse.button')
    .popup({
      on       : 'click',
      popup    : $('.admission.popup'),
      position : 'bottom left'
    })
  ;
  $('.nav.trigger')
    .visibility({
      onUpdate: function(calculations) {
        if( calculations.passing == false )
          $('#navigator').addClass('light');
        else
          $('#navigator').removeClass('light');
      },
      continuous: true
    })
  ;
  </script>

@else
  <!-- Index Page Navigator -->

  <div class="ui secondary pointing menu">
    <div class="ui container">
      <a class="ui item brand" href="/">
        <img src="/images/logo-light-min.png">&nbsp;
        Orion Online Judge
      </a>
      <a href="/problems" class="ui item {{ \App\Helpers::setActive('problems') }}">문제</a>
      <a href="#" class="ui item">대회</a>
      <a href="#" class="ui item">채점 현황</a>
      <a href="/rank" class="ui item" {{ \App\Helpers::setActive('rank') }}>랭킹</a>
      <a href="/articles" class="ui item {{ \App\Helpers::setActive('articles') }}">게시판</a>
      <a href="#" class="ui item">팀</a>
      @include('includes.navAuthButtons')
    </div>
  </div>

@endif

<script>
$('.ui.dropdown').dropdown();
</script>
</div>
