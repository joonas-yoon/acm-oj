<!DOCTYPE html>
<html lang="ko">
<head>
    @include('includes.head', ['site_title' => 'Orion Online Judge'])
</head>
<body>
    @include('includes.header')
    <div class="main content">
        @yield('content')
    </div>
    @include('includes.footer')

    @yield('script')
</body>
</html>