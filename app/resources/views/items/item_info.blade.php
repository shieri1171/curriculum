@extends(auth()->check() && auth()->user()->user_flg === 0 ? 'layouts.managiment' : 'layouts.layout')
@section('content')

<div class="container mt-5">
  <div class="row">
    <div class="col-12 col-md-8 mx-auto">
      <div class="row">
        <!-- 商品画像 -->
        <div class="col-12 col-md-6 d-flex justify-content-center">
          <div id="itemCarousel" class="carousel slide mb-3" data-bs-ride="carousel" style="width: 300px;">
            <div class="carousel-inner rounded shadow">
              @foreach ($item->itemImages as $key => $image)
                <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                  <img src="{{ asset('storage/' . $image->image_path) }}" alt=" {{ $item->name }} "  class="d-block w-100" style="height: 300px; object-fit: cover; display: block; margin: 0 auto;">
                </div>
              @endforeach
            </div>

            @if(count($item->itemImages) > 1)
              <button class="carousel-control-prev" type="button" data-bs-target="#itemCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#itemCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
              </button>
            @endif
          </div>
        </div>

        <!-- 商品情報 -->
        <div class="col-12 col-md-6">
          <h2>{{ $item->itemname }}</h2>
          <p class="mt-3"><strong>金額：</strong>¥{{ number_format($item->price) }}</p>
          <p class="mt-3"><strong>状態：</strong>{{ \App\Models\Item::ITEM_STATES[$item->state] }}</p>
          <p class="text-muted mt-3" style="max-height: 10.5em; overflow-y: auto; border: 1px solid #ccc; padding: 10px;">
              {!! nl2br(e($item->presentation)) !!}
          </p>
        </div>
      </div>
        
      <div class="row mt-5">
        <div class="col-12">
          <!-- コメント欄 -->
          <h4>コメント</h4>
          <div class="border p-3 rounded mb-4">
            @if($comments->isEmpty())
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
              @if(auth()->user()->user_flg === 0)
                <div class="input-group mb-1">
                  <input type="text" class="form-control" placeholder="管理ユーザーはコメントできません" disabled>
                  <button class="btn btn-secondary" disabled>送信</button>
                </div>
              @else
                <form id="commentForm">
                  @csrf
                  <input type="hidden" name="item_id" value="{{ $item->id }}">
                  <div class="input-group mb-1">
                    <input type="text" name="text" class="form-control" placeholder="コメントを入力してください" maxlength="100">
                    <button type="submit" class="btn btn-primary">送信</button>
                  </div>
                </form>
              @endif
            @else
              <div class="input-group mb-1">
                <input type="text" class="form-control" placeholder="コメントするにはログインが必要です" disabled>
                <a href="{{ route('login') }}" class="btn btn-primary">ログイン</a>
              </div>
            @endauth
          </div>
        </div>

        <!-- 出品者情報 -->
        <h5>出品者情報</h5>
        <div class="border p-3 rounded d-flex justify-content-center align-items-center pt-4 mt-4">
          <div class="d-flex align-items-center">
            <div>
              <img src="{{ asset('storage/' . $item->user->image) }}" class="rounded-circle me-4" alt="出品者画像" style="width: 80px; height: 80px;">
            </div>

            <div class="d-flex flex-column justify-content-center align-items-start ms-3 flex-grow-1">
              <div class="fw-bold">{{ $item->user->username }}</div>

              <div class="mt-2 d-flex gap-2 align-items-center">
                @auth
                  @if (auth()->user()->id == $item->user->id || auth()->user()->user_flg === 0)
                      <a href="{{ route('userpage', ['user' => $item->user->id]) }}" class="btn btn-secondary btn-sm">詳細</a>
                  @else
                    <button id='follow-btn' class="btn {{ auth()->user()->follows()->where('follow_id', $item->user->id)->exists() ? 'btn-info' : 'btn-outline-secondary' }}" 
                            data-user-id="{{ $item->user->id }}" 
                            data-url="{{ route('follow', $item->user->id) }}">
                        {{ auth()->user()->follows()->where('follow_id', $item->user->id)->exists() ? 'フォロー解除' : 'フォロー' }}
                    </button>
                    <a href="{{ route('userpage', ['user' => $item->user->id]) }}" class="btn btn-secondary btn-sm">詳細</a>
                  @endif              
                @else
                  <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm">フォロー</a>
                  <a href="{{ route('login') }}" class="btn btn-secondary btn-sm">詳細</a>
                @endauth
              </div>
            </div>
          </div>
        </div>
      </div>
      <div style="height: 80px;"></div>
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
          <a href="{{ route('item.edit', $item->id) }}" class="btn btn-warning">編集</a>
          <form action="{{ route('item.delete', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('この商品を削除してもよろしいですか？');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger ml-2">削除</button>
          </form>
        @endif

        <!-- 管理者の場合（削除のみ） -->
        @if(auth()->user()->user_flg === 0)
          @if($item->del_flg === 0)
            <form action="{{ route('item.delflg', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('この商品をストアから削除してもよろしいですか？');">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm">削除</button>
            </form>
          @else
            <form action="{{ route('item.restore', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('この商品をストアに復元しますか？');">
              @csrf
              <button type="submit" class="btn btn-success btn-sm">復元</button>
            </form>
          @endif
        @endif

      @else
        <!-- ログインしていない場合 -->
        <a href="{{ route('login') }}" class="btn btn-primary">購入</a>
        <a href="{{ route('login') }}" class="btn btn-outline-danger ml-2">いいね</a>
      @endauth
    </div>
  </div>
</div>

<script>
// コメント処理(Ajax)
  $('#commentForm').on('submit', function(e) {
    e.preventDefault();

    $.ajax({
      url: '{{ route("comment") }}', 
      method: 'POST',
      data: $(this).serialize(),
      success: function(response) {
        let isOwner = response.user_id === {{ $item->user_id }};
        let newComment = `
          <li class="list-group-item">
            <p class="mb-0 fw-bold"><strong>${response.user.username}</strong></p>
            <p class="mb-0">${response.text}</p>
            <p class="mb-0 text-muted small">${response.created_at}</p>
          </li>
        `;
        $('.list-group').append(newComment);
        $('#commentForm')[0].reset();
        $('.text-muted:contains("まだコメントはありません")').hide();
      },
      error: function() {
        alert('コメント送信に失敗しました');
      }
    });
  });

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

  // いいね処理(Ajax)
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
