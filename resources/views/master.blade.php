<!DOCTYPE html>
<html lang="ko">
<head>
    @include('includes.head', ['site_title' => 'Orion Online Judge'])
</head>
<body>
    @include('includes.header')
    <div class="ui main container">
        @yield('content')
    </div>
    @include('includes.footer')
</body>
</html>