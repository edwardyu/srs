<html>
    <head>
        <title>Podira - @yield('title')</title>
        @include('includes.head')
    </head>
    <body>
      @include('includes.header')
        <div class="container">
            @yield('content')
        </div>
    </body>
</html>
