@extends('layouts.layout')

@section('content')
<div class="container text-center">
  <div class="row">
    <div class="display-1 mt-5 mb-5 w-100">売上履歴一覧</div>
      @if($sells->isEmpty())
        <p>購入された商品は見つかりませんでした。</p>
      @else

        @foreach ($sells as $item)
          <div class="border p-3 rounded d-flex justify-content-center align-items-center pt-4 mt-4">
            <div class="d-flex align-items-center">
              <div>
                <img src="{{ asset('storage/' . $item->mainImage->image_path) }}" class="rounded-circle me-4" alt="商品画像" style="width: 60px; height: 60px;">
              </div>

              <div class="d-flex flex-column justify-content-between ms-3 flex-grow-1">
                  <div class="fw-bold">{{ $item->itemname }}</div>
                  <div class="fw-bold">￥{{ number_format($item->price) }}</div>
                  <a href="{{ route('item.info', ['item' => $item->id]) }}" class="btn btn-secondary btn-sm">詳細へ</a>
              </div>
            </div>
          </div>
        @endforeach
      @endif
    </div>
  </div>
</div>

@endsection