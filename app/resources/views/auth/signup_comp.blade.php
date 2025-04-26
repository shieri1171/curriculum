@extends('layouts.app')

@section('content')

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-header text-center">
          <h4 class="mb-0">新規登録が完了しました</h4>
        </div>
        <div class="card-body text-center">
          <p class="mb-4">ご登録ありがとうございます。下記ボタンからログインできます。</p>
          <a href="{{ route('login') }}" class="btn btn-primary">ログイン画面へ</a>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection