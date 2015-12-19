<!DOCTYPE html>
<html lang="ko">
<head>
    @include('includes.head')
    @yield('head')
</head>
<body>
    @include('includes.header')
    <div class="main content">
        @yield('content')
    </div>
    @include('includes.footer')

    @yield('script')
    
    <div id="site_title" style="display:none !important;">
        @yield('title')
    </div>
    <script>
        var docTitle = $('#site_title').text().trim();
        document.title= docTitle != '' ? docTitle : 'Orion Online Judge';
    </script>
</body>
</html>