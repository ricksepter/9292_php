<!DOCTYPE html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>9292_PHP</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
@yield('content')
</body>
</html>
