<!doctype html>
<html lang="en">
@include('main.meta')
<body>
@if(\App\Core\Session\Session::get('user'))
    @include('main.nav')
@endif
@yield('content')

@include('main.scripts')
</body>
</html>
