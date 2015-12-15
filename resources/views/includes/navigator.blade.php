
<!-- Navigator -->
<div class="nav" id="navigator">

@if ( isset($isIndex) )
  <!-- Index Page Navigator -->

  <div class="ui blue secondary fixed menu">
    <div class="ui container">
      <a href="/problems" class="ui item {{ active_class(if_uri_pattern(['problems/*', 'tags/*'])) }}">문제</a>
      <a href="#" class="ui item">대회</a>
      <a href="/solutions" class="ui item {{ active_class(if_uri_pattern(['solutions/*'])) }}">채점 현황</a>
      <a href="/rank" class="ui item {{ active_class(if_uri(['rank'])) }}">랭킹</a>
      <a href="/articles" class="ui item {{ active_class(if_uri_pattern(['articles/*'])) }}">게시판</a>
      <a href="#" class="ui item">팀</a>
      @include('includes.navAuthButtons')
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
          $('#navigator>.menu').addClass('light');
        else
          $('#navigator>.menu').removeClass('light');
      },
      continuous: true
    })
  ;
  </script>

@else
  <!-- Index Page Navigator -->

  <div class="ui blue secondary pointing menu">
    <div class="ui container">
      <a class="ui item brand" href="/">
        <img src="/images/logo-with-text.png" style="width:9.8em;">&nbsp;
        <!--Orion Online Judge-->
      </a>
      <a href="/problems" class="ui item {{ \App\Helpers::setActive('problems') }}">문제</a>
      <a href="#" class="ui item">대회</a>
      <a href="/solutions" class="ui item {{ \App\Helpers::setActive('solutions') }}">채점 현황</a>
      <a href="/rank" class="ui item {{ \App\Helpers::setActive('rank') }}">랭킹</a>
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
