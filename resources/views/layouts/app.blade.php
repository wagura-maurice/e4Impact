<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ strtoupper(config('app.name')) }}">
    <meta name="author" content="{{ ucwords(strtoupper(config('app.author.name'))) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ strtoupper(config('app.name')) }}</title>
    @include('layouts.partials.styles')
    @include('layouts.partials.scripts')
    <script type="text/javascript">
        var SITE_URL = "{{ config('app.url') }}";
        var CSRF_TOKEN = "{{ csrf_token() }}";
    </script>
</head>

<body>
    <div id="app">
        <div id="sidebar" class="active">
            @include('layouts.partials.sidebar')
        </div>
        <div id="main" class='layout-navbar'>
            @include('layouts.partials.header')
            <div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        @yield('breadcrumb')
                    </div>
                    <section class="section">
                        @yield('content')
                    </section>
                </div>
                @include('layouts.partials.footer')
            </div>
        </div>
    </div>
    @stack('scripts')
</body>

</html>
