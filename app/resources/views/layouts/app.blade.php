<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'メルカリ') }}</title>

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->

    @yield('stylesheet')
</head>
<body>
    <div id="app">
        <nav class="fixed-top navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid d-flex justify-content-start align-items-center">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('storage/unnamed.png') }}" alt="メルカリ" style="width: 60px; height: 60px;">
                </a>
            </div>
        </nav>
        <div style="height: 80px;"></div>
        @yield('content')
    </div>
</body>
</html>