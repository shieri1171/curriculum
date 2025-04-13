@extends('layouts.app')

@section('content')

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow-sm">
        <div class="card-header text-center">
          <h4 class="mb-0">商品の修正が完了しました</h4>
        </div>
        <div class="card-body text-center">
            <a href="{{ route('item.info') }}" class="btn btn-primary">商品画面へ</a>
            <a href="{{ route('userpage') }}" class="btn btn-primary">マイページへ</a>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection