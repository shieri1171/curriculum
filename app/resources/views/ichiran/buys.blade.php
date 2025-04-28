@extends('layouts.layout')

@section('content')
<div class="container text-center">
  <div class="row">
    <div class="display-1 mt-5 mb-5 w-100">購入履歴一覧</div>
      @if($buys->isEmpty())
        <p>該当する商品は見つかりませんでした。</p>
      @else

        @foreach ($buys as $item)
          <div class="col-md-6 col-sm-12 mb-4"> 
            <div class="border p-3 rounded d-flex justify-content-center align-items-center pt-4 mt-4">
              <div class="d-flex align-items-center">
                @if($item->item && $item->item->mainImage)
                  <img src="{{ asset('storage/' . $item->item->mainImage->image_path) }}" class="ms-5" alt="商品画像" style="width: 140px; height: 140px;">
                @else
                  <img src="{{ asset('storage/no_image/no_image_square.jpg') }}" class="ms-5" alt="削除済み商品" style="width: 140px; height: 140px;">
                @endif
              </div>

              <div class="d-flex flex-column justify-content-between ms-3 flex-grow-1">
                @if($item->item)
                  <h4 class="fw-bold">{{ $item->item->itemname }}</h4>
                  <div class="fw-bold">￥{{ number_format($item->item->price) }}</div>
                  <div class="fw-bold">購入日：{{ $item->created_at->format('Y年m月d日') }}</div>
                  <br>
                  <a href="{{ route('item.info', ['item' => $item->item->id]) }}" class="btn btn-outline-secondary btn-sm">詳細へ</a>
                @else
                  <div class="fw-bold text-secondary">削除された商品です</div>
                  <div class="fw-bold text-secondary">購入日：{{ $item->created_at->format('Y年m月d日') }}</div>
                @endif
              </div>
            </div>
          </div>
        @endforeach
      @endif
    </div>
  </div>
</div>

@endsection