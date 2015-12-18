<!DOCTYPE html>
<html lang="ko">
<head>
  @include('includes.head')
  <link rel="stylesheet" type="text/css" href="/assets/admin.css" />
</head>
<body>

  <div class="ui inverted vertical visible left sidebar menu">
    <div class="item">
      <a class="ui logo icon image" href="/">
        <img src="/images/logo-footer.png" style="width:50px;">
      </a>
      <a href="/admin"><b>관리자 화면</b></a>
    </div>
    <a class="item {{ active_class(if_uri(['admin'])) }}" href="/admin">
      대쉬보드
    </a>
    <a class="item {{ active_class(if_uri_start(['admin/problems'])) }}" href="/admin/problems">
      문제 관리
    </a>
  @for($i=1; $i<20; ++$i)
    <a class="item">
      {{ $i }}
    </a>
  @endfor
  </div>

  <div class="pusher pushed">
    <div class="ui masthead vertical segment">
      @yield('pre-content')
    </div>
    
    <div class="content">
      @yield('content')
    </div>
  </div>

  @include('includes.footer')
      
  @yield('script')
  
  <div id="site_title" style="display:none !important;">
    @yield('title')
  </div>
  <script>
    var docTitle = $('#site_title').text().trim();
    document.title= docTitle != '' ? docTitle : 'Orion Online Judge';
    $('.ui.sidebar').sidebar({
      onChange: function(){
        $('.pusher').toggleClass('pushed');
      }
    });
  </script>
</body>
</html>