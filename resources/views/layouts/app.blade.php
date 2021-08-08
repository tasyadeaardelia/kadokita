<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kado Kita</title>
    @stack('prepend-style')
        @include('includes.app.style')
    @stack('addon-style')
</head>
<body>
    <div class="site-wrap">
        <header class="site-navbar" role="banner">
            @include('includes.app.navbartop')

            @include('includes.app.navbar')
        </header>
        
        @yield('content')

        <footer class="site-footer border-top">
            @include('includes.app.footer')
        </footer>

    </div>

    @stack('prepend-script')
    @include('includes.app.script')
    @stack('addon-script')
</body>
</html>