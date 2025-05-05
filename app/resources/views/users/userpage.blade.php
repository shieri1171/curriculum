@extends(auth()->check() && auth()->user()->user_flg === 0 ? 'layouts.managiment' : 'layouts.layout')
@section('content')
    <div class="container mt-4">
        <div class="row align-items-start mb-4">
            <div class="col-md-5 text-center">
                <img src="{{ asset('storage/' . $user->image) }}" class="rounded-circle" alt="ユーザー画像" style="width: 200px; height: 200px; object-fit: cover;">
                <div class="mt-2 fw-bold">フォロー {{ $user->follows()->count() }}人</div>
                <div class="fw-bold">フォロワー {{ $user->followers()->count() }}人</div>
            </div>

            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h4 class="fw-bold">{{ $user->username }}</h4>
                    <div>
                        @auth
                            <!-- 一般ユーザー(出品者以外)の場合 -->
                            @if(auth()->user()->id !== $user->id && auth()->user()->user_flg === 1)
                                <button id='follow-btn' class="btn {{ auth()->user()->follows()->where('follow_id', $user->id)->exists() ? 'btn-info' : 'btn-outline-secondary' }}" 
                                        data-user-id="{{ $user->id }}" 
                                        data-url="{{ route('follow', $user->id) }}">
                                    {{ auth()->user()->follows()->where('follow_id', $user->id)->exists() ? 'フォロー解除' : 'フォロー' }}
                                </button>
                            <!-- 出品者本人の場合 -->
                            @elseif(auth()->user()->id === $user->id)
                                <a href="{{ route('profile.edit', $user->id) }}" class="btn btn-warning">プロフィール編集</a>
                                <form action="{{ route('user.delete', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('本当に削除しますか？');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">アカウント削除</button>
                                </form>
                            <!-- 管理者の場合 -->
                            @elseif(auth()->user()->user_flg === 0)
                                @if($user->del_flg == 0)
                                    <form action="{{ route('user.delflg', ['user' => $user->id]) }}" method="POST" style="display:inline;" onsubmit="return confirm('このユーザーを利用停止にしてもよろしいですか？');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">利用停止</button>
                                    </form>

                                    <form action="{{ route('user.flg', ['user' => $user->id]) }}" method="POST" style="display:inline;" onsubmit="return confirm('このユーザーを管理ユーザーにしますか？');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" style="background-color: white; color: orange; border: 1px solid orange; border-radius: 4px;" class="btn btn-outline-success btn-sm">管理ユーザーに変更</button>
                                    </form>

                                @elseif($user->del_flg == 1)
                                    <form action="{{ route('user.restore', ['user_id' => $user->id]) }}" method="POST" style="display:inline;" onsubmit="return confirm('このユーザーをストアに復元しますか？');">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-info btn-sm">復元</button>
                                    </form>
                                @endif
                            @endif
                        @else
                            <!-- ログインしていない場合 -->
                            <a href="{{ route('login') }}" class="btn btn-primary">フォロー</a>
                        @endauth
                    </div>
                </div>
                <p class="mt-5" style="max-height: 9em; overflow-y: auto; border: 1px solid #ccc; padding: 10px;">
                    {!! nl2br(e($user->profile)) !!}
                </p>
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

<script>
// フォロー処理
  document.getElementById('follow-btn').addEventListener('click', async function () {
    const userId = this.getAttribute('data-user-id');
    const url = this.getAttribute('data-url');
    const btn = this;

    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
        });

        const data = await response.json();

        if (data.status === 'followed') {
            btn.classList.remove('btn-outline-secondary');
            btn.classList.add('btn-info');
            btn.textContent = 'フォロー解除';
        } else {
            btn.classList.remove('btn-info');
            btn.classList.add('btn-outline-secondary');
            btn.textContent = 'フォロー';
        }
    } catch (error) {
        console.error('エラー:', error);
    }
  });
</script>

@endsection