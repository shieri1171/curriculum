@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <div class="card">
    <div class="card-header text-center">
      <h2><b>新規登録　内容確認</b></h2>
    </div>
    <div class="card-body">
      <p>下記の内容をご確認の上登録ボタンを押してください。</p>
      <p>内容を訂正する場合は「戻る」を押してください。</p>
    
      <form action="{{ route('signup.comp') }}" method="POST">
        @csrf

        <dl class="row">
          <dt class="col-sm-3">メールアドレス</dt>
          <dd class="col-sm-9">{{ session('email') }}</dd>

          <dt class="col-sm-3">ユーザー名</dt>
          <dd class="col-sm-9">{{ session('username') }}</dd>

          <dt class="col-sm-3">パスワード</dt>
          <dd class="col-sm-9">{{ session('password') }}</dd>
        </dl>

        <div class="text-center mt-4">
          <button type="submit" class="btn btn-primary">登録</button>
          <a href="{{ route('signup') }}" class="btn btn-secondary">戻る</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection