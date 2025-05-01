@extends('layouts.layout')

@section('content')
<div class="container text-center">
  <div class="row">
    <div class="display-1 mt-5 mb-5 w-100">フォロー一覧</div>
    @if($follows->isEmpty())
      <p>フォローしているユーザーがいません。</p>
    @else

      @foreach ($follows as $follow)
        <div class="col-md-6 col-sm-12 mb-4"> 
          <div class="border p-3 rounded d-flex justify-content-center align-items-center pt-4 mt-4">
            <div class="d-flex align-items-center">
              <div>
                <img src="{{ asset('storage/' . $follow->followedUser->image) }}" class="rounded-circle me-4" alt="ユーザー画像" style="width: 140px; height: 140px;">
              </div>

              <div class="d-flex flex-column justify-content-between ms-3 flex-grow-1">
                <div class="fw-bold">{{ $follow->followedUser->username }}</div>

                <div class="mt-2 d-flex gap-2">
                    <a href="{{ route('userpage', ['user' => $follow->followedUser->id]) }}" class="btn btn-secondary">ショップを見る</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    @endif
  </div>
</div>

@endsection