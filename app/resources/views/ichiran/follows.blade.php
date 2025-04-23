@extends('layouts.layout')

@section('content')
<div class="container text-center">
  <div class="row">
    <div class="display-1 mt-5 mb-5 w-100">フォロー一覧</div>
    @if($follows->isEmpty())
      <p>フォローしているユーザーがいません。</p>
    @else

      @foreach ($follows as $user)
        <div class="border p-3 rounded d-flex justify-content-center align-items-center pt-4 mt-4">
          <div class="d-flex align-items-center">
            <div>
              <img src="{{ asset('storage/' . $user->image) }}" class="rounded-circle me-4" alt="ユーザーユーザー画像" style="width: 60px; height: 60px;">
            </div>

            <div class="d-flex flex-column justify-content-between ms-3 flex-grow-1">
              <div class="fw-bold">{{ $user->username }}</div>

              <div class="mt-2 d-flex gap-2">
                  <a href="{{ route('userpage', ['user' => $user->id]) }}" class="btn btn-secondary btn-sm">ショップを見る</a>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    @endif
  </div>
</div>

@endsection