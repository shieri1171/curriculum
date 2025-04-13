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
      <p><strong>状態：</strong>{{ $item->state }}</p>
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

@endsection
