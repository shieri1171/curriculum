@extends('layouts.layout')

@section('content')

<div class="container mt-5">
  <div class="row">
    <!-- 商品画像 -->
    @foreach ($item->itemImages as $image)
      <div class="col-12 col-md-6 text-center">
        <img src="{{ asset('storage/' . $image->image_path) }}" class="img-fluid rounded shadow" alt="{{ $item->name }}">
      </div>
    @endforeach

    <!-- 商品情報 -->
    <div class="col-md-6">
      <br>
      <h2>{{ $item->itemname }}</h2>
      <br>
      <p><strong>金額：</strong>¥{{ number_format($item->price) }}</p>
      <br>
      <p><strong>状態：</strong>{{ \App\Models\Item::ITEM_STATES[$item->state] }}</p>
    </div>
  </div>
    
    <div class="row mt-5">
    <div class="col-12">
      <p class="text-muted">{{ $item->presentation }}</p>

      <!-- コメント欄 -->
      <h4>コメント</h4>
      <div class="border p-3 rounded mb-4">
        @if(is_null($item->comments))
          <p class="text-muted">まだコメントはありません。</p>
        @else
          <ul class="list-group">
            @foreach($comments as $comment)
              @php
                $isOwner = $comment->user_id === $item->user_id;
              @endphp
              <li class="list-group-item {{ $isOwner ? 'text-end bg-light' : '' }}">
                  <p class="mb-0 fw-bold"><strong>{{ $comment->user->username }}</strong></p>
                  <p class="mb-0">{{ $comment->text }}</p>
                  <p class="mb-0 text-muted small">{{ $comment->created_at->format('Y-m-d H:i') }}</p>
              </li>
            @endforeach
          </ul>
        @endif

        @auth
          <form action="{{ route('comment') }}" method="POST">
            @csrf
            <input type="hidden" name="item_id" value="{{ $item->id }}">
            <div class="input-group mb-1">
              <input type="text" name="comment" class="form-control" placeholder="コメントを入力してください" maxlength="100" required>
              <button type="submit" class="btn btn-primary">送信</button>
            </div>
          </form>
        @else
          <p>コメントするには <a href="{{ route('login') }}">ログイン</a> が必要です。</p>
        @endauth
      </div>

      <!-- 出品者情報 -->
      <h5>出品者情報</h5>
      <div class="border p-3 rounded d-flex justify-content-center align-items-center pt-4 mt-4">
        <div class="d-flex align-items-center">
          <div>
            <img src="{{ asset('storage/' . $item->user->image) }}" class="rounded-circle me-4" alt="出品者画像" style="width: 60px; height: 60px;">
          </div>

          <div class="d-flex flex-column justify-content-between ms-3 flex-grow-1">
            <div class="fw-bold">{{ $item->user->username }}</div>

            <div class="mt-2 d-flex gap-2">
              @auth
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
                <a href="{{ route('userpage', ['user' => $item->user->id]) }}" class="btn btn-secondary btn-sm">詳細</a>
              @else
                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">フォロー</a>
                <a href="{{ route('login') }}" class="btn btn-secondary btn-sm">詳細</a>
              @endauth
            </div>
          </div>
        </div>
      </div>
      <br>
      <br>
      <br>
    </div>
  </div>
</div>

<!-- フッター -->
<div class="fixed-bottom bg-white border-top py-2">
    <div class="col-12 text-center">
      @auth
        <!-- 購入ボタン -->
        @if(auth()->user()->id !== $item->user_id && auth()->user()->user_flg === 1)
          @if ($item->sell_flg == 0)
            <a href="{{ route('buy.item', $item->id) }}" class="btn btn-primary">購入</a>
          @else
            <button class="btn btn-secondary" disabled>売り切れ</button>
          @endif
          
          <button id="favorite-btn" data-item-id="{{ $item->id }}" class="btn p-0 border-0 bg-transparent ms-2">
            <i id="heart-icon" class="fa{{ $isFavorited ? 's' : 'r' }} fa-heart fa-lg {{ $isFavorited ? 'text-danger' : 'text-secondary' }}"></i>
          </button>
        @endif

        <!-- 出品者本人の場合（編集・削除） -->
        @if(auth()->user()->id === $item->user_id)
          <a href="{{ route('itemedit', $item->id) }}" class="btn btn-warning">編集</a>
          <form action="{{ route('item.delete', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('この画像を削除してもよろしいですか？');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger ml-2">削除</button>
          </form>
        @endif

        <!-- 管理者の場合（削除のみ） -->
        @if(auth()->user()->user_flg === 0)
          <form action="{{ route('item.delete', $item->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">削除</button>
          </form>
        @endif

      @else
        <!-- ログインしていない場合 -->
        <a href="{{ route('login') }}" class="btn btn-primary">購入</a>
        <a href="{{ route('login') }}" class="btn btn-outline-danger ml-2">いいね</a>
      @endauth
    </div>
  </div>
</div>

<!-- いいね処理(Ajax) -->
<script>
document.getElementById('favorite-btn').addEventListener('click', function () {
    const itemId = this.getAttribute('data-item-id');
    const icon = this.querySelector('#heart-icon');

    fetch('{{ route('favorite') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ item_id: itemId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'liked') {
            icon.classList.remove('far', 'text-secondary');
            icon.classList.add('fas', 'text-danger');
        } else {
            icon.classList.remove('fas', 'text-danger');
            icon.classList.add('far', 'text-secondary');
        }
    })
    .catch(error => {
        console.error('エラー:', error);
    });
});
</script>

@endsection
