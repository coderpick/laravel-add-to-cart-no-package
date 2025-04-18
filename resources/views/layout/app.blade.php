<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.head')
    @stack('custom_css')
</head>

<body>

    @include('layout.nav')
    @yield('content')
    @include('layout.footer')
    @stack('custom_js')
</body>

</html>
