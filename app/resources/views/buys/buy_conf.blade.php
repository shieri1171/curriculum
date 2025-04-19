@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <div class="card">
    <div class="card-header text-center">
      <h2><b>購入内容確認</b></h2>
    </div>
    <div class="card-body">
      <p>下記の内容をご確認の上購入ボタンを押してください。</p>
      <p>購入者情報を修正する場合は「修正」を押してください。</p>
    
      <form action="{{ route('buy.comp') }}" method="POST">
        @csrf

        <dl class="row">
            <dt class="col-sm-3">商品画像</dt>
            <dd class="col-sm-9">
                <div class="row">
                @foreach ($item->itemImages as $path)
                    <div class="col-md-3 mb-3">
                        <img src="{{ asset('storage/' . $path->image_path) }}" class="img-fluid rounded shadow" alt="商品画像">
                    </div>
                @endforeach
                </div>
            </dd>

            <dt class="col-sm-3">商品名</dt>
            <dd class="col-sm-9">{{ $item->itemname }}</dd>

            <dt class="col-sm-3">金額</dt>
            <dd class="col-sm-9">￥{{ $item->price }}</dd>
            
            <dt class="col-sm-3">商品状態</dt>
            <dd class="col-sm-9">{{ \App\Models\Item::ITEM_STATES[$item->state] }}</dd>

            <dt class="col-sm-3">商品説明</dt>
            <dd class="col-sm-9">{{ $item->presentation }}</dd>

            <dt class="col-sm-3">氏名</dt>
            <dd class="col-sm-9">{{ session('name') }}</dd>

            <dt class="col-sm-3">電話番号</dt>
            <dd class="col-sm-9">{{ session('tel') }}</dd>

            <dt class="col-sm-3">郵便番号</dt>
            <dd class="col-sm-9">{{ session('postcode') }}</dd>

            <dt class="col-sm-3">住所</dt>
            <dd class="col-sm-9">{{ session('address') }}</dd>

        </dl>

        <div class="text-center mt-4">
          <a href="{{ route('user.info') }}" class="btn btn-secondary">修正</a>
          <button type="submit" class="btn btn-primary">購入</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection