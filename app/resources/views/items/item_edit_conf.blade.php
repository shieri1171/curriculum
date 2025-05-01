@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <div class="row">
    <div class="col-12 col-md-6 mx-auto">
      <div class="card">  
        <div class="card-header text-center">
          <h2><b>内容確認</b></h2>
        </div>
        <div class="card-body">
          <p>下記の内容をご確認の上修正ボタンを押してください。</p>
          <p>内容を訂正する場合は「戻る」を押してください。</p>
        
          <form action="{{ route('item.edit.comp', ['item' => session('item_id')]) }}" method="POST">
            @csrf

            <dl class="row">
              <dt class="col-sm-3">商品画像</dt>
              <dd class="col-sm-9">
                <div class="row">
                  @foreach (session('existing_images', []) as $path)
                    <div class="col-md-3 mb-3">
                      <img src="{{ asset('storage/' . $path) }}" class="img-fluid rounded shadow" alt="既存商品画像" style="width:150px; height:150px; object-fit: cover;">
                    </div>
                  @endforeach

                  @foreach (session('images', []) as $path)
                    <div class="col-md-3 mb-3">
                      <img src="{{ asset('storage/' . $path) }}" class="img-fluid rounded shadow" alt="商品画像" style="width:150px; height:150px; object-fit: cover;">
                    </div>
                  @endforeach
                </div>
              </dd>

              <dt class="col-sm-3">商品名</dt>
              <dd class="col-sm-9">{{ session('itemname') }}</dd>

              <dt class="col-sm-3">金額</dt>
              <dd class="col-sm-9">￥{{ number_format(session('price')) }}</dd>
              
              <dt class="col-sm-3">商品状態</dt>
              <dd class="col-sm-9">{{ \App\Models\Item::ITEM_STATES[session('state')] }}</dd>

              <dt class="col-sm-3">商品説明</dt>
              <dd class="col-sm-9">{{ session('presentation') }}</dd>
            </dl>

            <div class="text-center mt-4">
              <button type="submit" class="btn btn-primary">修正</button>
              <a href="{{ route('item.edit', ['item' => session('item_id')]) }}" class="btn btn-secondary">戻る</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection