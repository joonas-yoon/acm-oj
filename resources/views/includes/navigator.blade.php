
<!-- Navigator -->
<div class="nav" id="navigator">

  <div class="ui blue secondary {{ isset($isIndex) ? 'fixed' : 'pointing' }} menu">
    <div class="ui container">
      @if ( ! isset($isIndex) )
      <a class="ui item brand" href="/">
        <img src="/images/logo-with-text.png" style="width:9.8em;">&nbsp;
        <!--Orion Online Judge-->
      </a>
      @endif
      <a href="/problems" class="ui item {{ active_class(if_uri_start(['problems', 'tags'])) }}">문제</a>
      <a href="#" class="ui item">대회</a>
      <a href="/solutions" class="ui item {{ active_class(if_uri_start(['solutions'])) }}">채점 현황</a>
      <a href="/rank" class="ui item {{ active_class(if_uri_start(['rank'])) }}">랭킹</a>
      <a href="/articles" class="ui item {{ active_class(if_uri_start(['articles'])) }}">게시판</a>
      <a href="#" class="ui item">팀</a>
      @include('includes.navAuthButtons')
    </div>
  </div>
  
@if ( isset($isIndex) )
  <!-- Index Page Navigator -->
  <div class="nav trigger"></div>

  <script>
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
@endif

<script>
  $('.ui.dropdown').dropdown();
</script>

</div>
