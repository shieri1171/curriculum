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
      @if(is_null($item->comments))
        <p class="text-muted">まだコメントはありません。</p>
      @else
        <ul class="list-group">
          @foreach($item->comments->sortBy('created_at') as $comment)
            <li class="list-group-item">
              <p class="mb-1">{{ $comment->text }}</p>
              <small class="text-muted">{{ $comment->created_at->format('Y年m月d日 H:i') }}</small>
            </li>
          @endforeach
        </ul>
      @endif
    </div>
  </div>
</div>

<!-- フッター -->
<div class="row mt-5">
    <div class="col-12 text-center">
      @auth
        <!-- 購入ボタン -->
        @if(auth()->user()->id !== $item->user_id)
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
