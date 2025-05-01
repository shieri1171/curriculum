@extends('layouts.app')

@section('content')

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-12 col-md-6 mx-auto"> 
      <div class="card shadow-sm">
        <div class="card-header text-center">
          <h4 class="mb-0">出品が完了しました</h4>
        </div>
        <div class="card-body text-center">
          <div class="mb-3">
            <a href="{{ route('item') }}" class="btn btn-primary">続けて出品</a>
          </div>
          <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('item.info', ['item' => $item->id]) }}" class="btn btn-outline-primary">商品画面へ</a>
            <a href="{{ route('top') }}" class="btn btn-outline-primary">トップページへ</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection