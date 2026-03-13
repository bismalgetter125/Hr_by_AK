<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Your CSS -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body>

    {{ $navabr ?? '' }}
    {{ $sidebar ?? '' }}

    @yield('content')

    {{ $footer ?? '' }}

    @yield('js')

    @stack('scripts')

</body>
</html>