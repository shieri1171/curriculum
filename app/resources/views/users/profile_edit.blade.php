@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card mb-4">
        <div class="card-header text-center">プロフィール修正</div>
        @if($errors->any())
          <div class="alert alert-danger">
            @foreach($errors->all() as $message)
              <p>{{ $message }}</p>
            @endforeach
          </div>
        @endif

        <div class="card-body">
          <form action="{{ route('profile.edit.comp', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="d-flex align-items-center mb-3">
              <img src="{{ asset('storage/' . $user->image) }}" class="rounded-circle me-3" alt="ユーザー画像" style="width: 60px; height: 60px;">
              <div class="flex-grow-1">
                <label for="image" class="form-label">アイコン</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
              </div>
            </div>
            <div class="mb-3">
              <label for="username" class="form-label">ユーザー名</label>
              <input type="text" class="form-control" id="username" name="username"
                value="{{ old('username', $user->username) }}">
            </div>
            <div class="mb-3">
              <label for="profile" class="form-label">プロフィール文</label>
              <textarea class="form-control" id="profile" name="profile" rows="3">{{ old('profile', $user->profile) }}</textarea>
            </div>
            //購入者情報
            <div class="card mt-4">
              <div class="card-header">購入者情報</div>
              <div class="card-body">
                <div class="mb-3">
                  <label for="name" class="form-label">氏名</label>
                  <input type="text" class="form-control" id="name" name="name" value="{{ old('name', session('name')) }}">
                </div>

                <div class="mb-3">
                  <label for="tel" class="form-label">電話番号</label>
                  <input type="tel" class="form-control" id="tel" name="tel" value="{{ old('tel', session('tel')) }}">
                </div>

                <div class="mb-3">
                  <label for="postcode" class="form-label">郵便番号</label>
                  <input type="tel" class="form-control" id="postcode" name="postcode" value="{{ old('postcode', session('postcode')) }}">
                </div>

                <div class="mb-3">
                  <label for="address" class="form-label">住所</label>
                  <input type="text" class="form-control" id="address" name="address" value="{{ old('address', session('address')) }}">
                </div>
              </div>
            </div>

            <div class="text-center mt-4">
              <button type="submit" class="btn btn-primary">確認</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection