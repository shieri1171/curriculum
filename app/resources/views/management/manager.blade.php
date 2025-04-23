@extends('layouts.managiment')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col col-md-offset-3 col-md-6">
        <nav class="card mt-5 text-center">
          <div class="card-header">管理者用メニュー</div>
          <div class="card-body">
            <a href="{{ route('manager.user') }}" class="btn btn-primary">ユーザー一覧</a>
            <a href="{{ route('manager.item') }}" class="btn btn-primary">商品一覧</a>
          </div>
        </nav>
      </div>
    </div>
  </div>
@endsection