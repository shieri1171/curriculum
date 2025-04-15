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
        <!-- 出品者本人の場合（編集・削除） -->
        @if(auth()->user()->id === $item->user_id)
          <a href="{{ route('edit.item', $item->id) }}" class="btn btn-warning">編集</a>
          <form action="{{ route('delete.item', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('この画像を削除してもよろしいですか？');">
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

@endsection
