<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication system</title>
</head>
<body>
    @if(Session::has('global'))
        <p>{{Session::get('global')}}</p>
    @endif
    @include('layout.navigation')
    @yield('content')
</body>
</html>
