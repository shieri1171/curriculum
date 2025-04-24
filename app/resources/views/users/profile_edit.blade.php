@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col col-md-offset-3 col-md-6">
        <nav class="card mt-5">
          <div class="card-header text-center">プロフィール編集</div>
          <div class="card-body">
            @if($errors->any())
              <div class="alert alert-danger">
                @foreach($errors->all() as $message)
                  <p>{{ $message }}</p>
                @endforeach
              </div>
            @endif

            @if ($user->images->count())
              <div class="mb-3">
                <p>アイコン：</p>
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <img src="{{ asset('storage/' . $user->image) }}" class="img-thumbnail" alt="登録済み画像">
                    </div>
                </div>
              </div>
            @endif

            <form action="{{ route('profile.edit.conf', $user->id) }}" method="POST">
              @csrf
              @method('PUT')
              <input type="hidden" name="id" value="{{ $user->id }}">
              <div class="form-group">
                <label for="images">アイコン</label>
              <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*" />
              <br>
              <div class="form-group">
                <label for="username">ユーザー名</label>
                <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $user['username']) }}" />
              </div>
              <br>
              <div class="form-group">
                <label for="profile">プロフィール文</label>
                <input type="text" class="form-control" id="profile" name="profile" value="{{ old('profile', $user['profile']) }}" />
              </div>
              <br>
              <div class="text-center">
                <button type="submit" class="btn btn-primary">確認</button>
              </div>
            </form>
          </div>
        </nav>
      </div>
    </div>
  </div>
@endsection