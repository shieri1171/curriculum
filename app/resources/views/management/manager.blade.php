@extends('layouts.managiment')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col col-md-offset-3 col-md-6">
        <nav class="card mt-5 text-center">
          <h4 class="card-header">管理者用メニュー</h4>
          <div class="card-body">
            <a href="{{ route('manager.user') }}" class="btn btn-outline-success btn-lg mt-3 mb-5">ユーザー一覧</a>
            <br>
            <a href="{{ route('manager.item') }}" class="btn btn-outline-success btn-lg mb-3">商品一覧</a>
          </div>
        </nav>
      </div>
    </div>
  </div>
@endsection