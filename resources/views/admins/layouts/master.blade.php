<!DOCTYPE html>
<html lang="ko">
<head>
    @include('includes.head')
</head>
<body>
    <div class="ui sidebar inverted vertical visible menu">
        <a class="item">
          1
        </a>
        <a class="item">
          2
        </a>
        <a class="item">
          3
        </a>
    </div>
    <div class="pusher">
        @yield('content')
        
        @include('includes.footer')
    </div>

    @yield('script')
    
    <div id="site_title" style="display:none !important;">
        @yield('title')
    </div>
    <script>
        var docTitle = $('#site_title').text().trim();
        document.title= docTitle != '' ? docTitle : 'Orion Online Judge';
        $('.ui.sidebar').sidebar();
    </script>
</body>
</html>