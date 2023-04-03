<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ strtoupper(config('app.name')) }}">
    <meta name="author" content="{{ ucwords(strtoupper(config('app.author.name'))) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ strtoupper(config('app.name')) }}</title>
    <link rel="stylesheet" href="{{ asset('css/main/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages/auth.css') }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
</head>

<body>
    <div id="auth">
        @yield('content')
    </div>
    <!-- Scripts -->
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</body>

</html>
