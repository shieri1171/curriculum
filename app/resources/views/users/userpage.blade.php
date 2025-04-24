@extends('layouts.layout')

@section('content')
    <div class="container mt-4">
        <div class="row align-items-start mb-4">
            <div class="col-md-4 text-center">
                    <img src="{{ asset('storage/' . $user->image) }}" class="rounded-circle" alt="ユーザー画像" style="width: 80px; height: 80px;">
                    <div class="mt-2 fw-bold">フォロー {{ $user->follows()->count() }}人</div>
                    <div class="fw-bold">フォロワー {{ $user->followers()->count() }}人</div>
                </div>

                <div class="col-md-8">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="fw-bold">{{ $user->username }}</h4>
                            @auth
                                @foreach($items as $item)
                                    <!-- 一般ユーザー(出品者以外)の場合 -->
                                    @if(auth()->user()->id !== $item->user_id && auth()->user()->user_flg === 1)
                                        @if (auth()->user()->follows()->where('followed_user_id', $user->id)->exists())
                                            <form action="{{ route('unfollow', $user->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-secondary">フォロー解除</button>
                                            </form>
                                        @else
                                            <form action="{{ route('follow', $user->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary">フォロー</button>
                                            </form>
                                        @endif
                                    <!-- 出品者本人の場合 -->
                                    @elseif(auth()->user()->id === $item->user_id)
                                        <a href="{{ route('profile.edit', $user->id) }}" class="btn btn-warning">プロフィール編集</a>
                                        <form action="{{ route('user.delete', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('本当に削除しますか？');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">アカウント削除</button>
                                        </form>
                                    <!-- 管理者の場合 -->
                                    @elseif(auth()->user()->user_flg === 0)
                                        <form action="{{ route('user.delflg', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('このアカウントを停止しますか？');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">アカウント停止</button>
                                        </form>
                                        <form action="{{ route('user.flg', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('ユーザー種別を変更しますか？');">
                                            @csrf
                                            @php
                                                $isAdmin  = $user->user_flg === 0;
                                            @endphp
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-secondary">
                                                {{ $isAdmin ? '一般ユーザーに変更' : '管理ユーザーに変更' }}
                                            </button>
                                        </form>
                                    @endif
                                @endforeach
                            @else
                                <!-- ログインしていない場合 -->
                                <a href="{{ route('login') }}" class="btn btn-primary">フォロー</a>
                            @endauth
                        </div>
                        <p class="mt-2">{{ $user->profile }}</p>
                    </div>
                </div>

        <div class="row row-cols-3 row-cols-md-3 row-cols-xl-5">
            @foreach ($items as $item)
                <div class="col mb-4">
                    <a href="{{ route('item.info', ['item' => $item->id]) }}" class="text-decoration-none text-dark">
                        <div class="card h-100 shadow-sm d-flex flex-column">
                            <div class="ratio ratio-1x1">
                                <img src="{{ asset('storage/' . $item->mainImage->image_path) }}" class="card-img-top object-fit-cover rounded-top" alt="{{ $item->itemname }}">
                            </div>
                            <hr class="my-0">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title mb-0 fs-6">{{ $item->itemname }}</h5>
                                <p class="card-text text-primary fw-bold mt-auto">￥{{ number_format($item->price) }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>    
    </div>
@endsection