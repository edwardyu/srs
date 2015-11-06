<html>
    <head>
        <title>Podira - @yield('title')</title>
        @include('includes.head')
    </head>
    <body>
        @include('includes.header')
        <div class="container" style="height:auto;">
            @yield('content')
        </div>
        @include('includes.footer')
    </body>
</html>
