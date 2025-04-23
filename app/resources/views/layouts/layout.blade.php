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
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <a class="btn btn-outline-primary" href="{{ url('/') }}">
                    メルカリ
                </a>
                <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                    <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#searchModal">
                        検索
                    </button>
                </div>
                @if(Auth::check())
                    <div class="my-navbar-cotrol">
                        <a type="button" class="my-navbar-item btn btn-outline-primary" href="{{ route('item') }}">+ 出品</a >
                        <span class="my-navbar-item" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" style="cursor: pointer;">
                            <img src="{{ asset('storage/' . Auth::user()->image) }}" class="rounded-circle" alt="User Image" style="width: 40px; height: 40px;">
                        </span>
                    </div>

                    <!-- サイドメニュー ここから -->
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="sidebarMenuLabel">メニュー</h5>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <ul class="list-unstyled">
                                <li><a href="{{ route('favorites') }}" class="nav-link">いいねした商品</a></li>
                                <li><a href="{{ route('buys') }}" class="nav-link">購入履歴</a></li>
                                <li><a href="{{ route('follows') }}" class="nav-link">フォロー一覧</a></li>
                                <li><a href="{{ route('sells') }}" class="nav-link">売上履歴</a></li>
                                <li>
                                    @if(request()->is('userpage/*') && auth()->user()->id == $user->id)
                                        <!-- マイページの場合 -->
                                        <a href="{{ route('edit.profile', ['user' => $user]) }}" class="nav-link">プロフィール編集</a>
                                    @else
                                        <!-- 他ページの場合 -->
                                        <a href="{{ route('userpage', ['user' => $user]) }}" class="nav-link">マイページへ</a>
                                    @endif
                                </li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">ログアウト</button>
                                </form>
                            </ul>
                        </div>
                    </div>
                    <!-- サイドメニュー ここまで -->

                @else
                    <div class="my-navbar-cotrol">
                        <a type="button" class="my-navbar-item btn btn-outline-primary" href="{{ route('login') }}">ログイン</a >
                        <a type="button" class="my-navbar-item btn btn-outline-primary" href="{{ route('signup') }}">会員登録</a >
                    </div>
                @endif
                
            </div>
        </nav>
        <br>
        <br>

        <!-- 検索モーダル ここから -->
        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('item.search') }}" method="GET" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="searchModalLabel">商品検索</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                    <label for="keyword" class="form-label">キーワード</label>
                    <input type="text" class="form-control" id="keyword" name="keyword" placeholder="商品名や説明">
                    </div>
                    <div class="mb-3">
                    <label for="price_range" class="form-label">価格帯</label>
                    <select class="form-select" id="price_range" name="price_range">
                        <option value="">指定なし</option>
                        <option value="0-999">~999円</option>
                        <option value="1000-4999">1,000~4,999円</option>
                        <option value="5000-9999">5,000~9,999円</option>
                        <option value="10000-99999">10,000~39,999円</option>
                        <option value="10000-99999">40,000~69,999円</option>
                        <option value="10000-99999">70,000~99,999円</option>
                    </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">検索する</button>
                </div>
                </form>
            </div>
        </div>
        <!-- 検索モーダル ここまで-->

        @yield('content')
    </div>
</body>
</html>