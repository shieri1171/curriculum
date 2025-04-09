<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'メルカリ') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('stylesheet')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container d-flex justify-content-between align-items-center">
                <a class="navbar-brand" href="{{ url('/') }}">
                    メルカリ
                </a>
                <div class="text-center flex-grow-1">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#searchModal">
                        検索
                    </button>
                </div>
                <div class="my-navbar-cotrol">
                    @if(Auth::check())
                        <span class="my-navbar-item">{{ Auth::user()->image }}</span>
                    @else
                        <button type="button" class="my-navbar-item" href="{{ route('login') }}">ログイン</button >
                        <button type="button" class="my-navbar-item" href="{{ route('signup') }}">会員登録</button >
                    @endif
                </div>
            </div>
        </nav>
        @yield('content')
    </div>
</body>
</html>