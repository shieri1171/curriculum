@extends('layouts.managiment')

@section('content')
<div class="container text-center">
    <div class="row">
        <div class="display-1 mt-5 mb-5 w-100">ユーザー一覧</div>
            @foreach ($users as $user)
                <div class="col-md-6 col-sm-12 mb-4"> 
                    <div class="border p-3 rounded d-flex justify-content-center align-items-center pt-4 mt-4">
                        <div class="d-flex align-items-center">
                            <div>
                                <img src="{{ asset('storage/' . $user->image) }}" class="rounded-circle me-4" alt="ユーザー画像" style="width: 140px; height: 140px;">
                            </div>

                            <div class="d-flex flex-column justify-content-between ms-3 flex-grow-1">
                                <div class="fw-bold">{{ $user->username }}</div>

                                <div class="mt-2 d-flex gap-2">
                                    {{-- 一般ユーザーで停止されていない場合 --}}
                                    @if($user->user_flg == 1 && $user->del_flg == 0)
                                        <a href="{{ route('userpage', ['user' => $user->id]) }}" class="btn btn-outline-secondary btn-sm">ユーザーページへ</a>

                                        <form action="{{ route('user.delflg', ['user' => $user->id]) }}" method="POST" style="display:inline;" onsubmit="return confirm('このユーザーを利用停止にしてもよろしいですか？');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">利用停止</button>
                                        </form>

                                        <form action="{{ route('user.flg', ['user' => $user->id]) }}" method="POST" style="display:inline;" onsubmit="return confirm('このユーザーを管理ユーザーにしますか？');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" style="background-color: white; color: orange; border: 1px solid orange; border-radius: 4px;" class="btn btn-outline-success btn-sm">管理ユーザーに変更</button>
                                        </form>

                                    {{-- 一般ユーザーで停止されている場合 --}}
                                    @elseif($user->user_flg == 1 && $user->del_flg == 1)
                                        <a href="{{ route('userpage', ['user' => $user->id]) }}" class="btn btn-outline-secondary btn-sm">ユーザーページへ</a>

                                        <form action="{{ route('user.restore', ['user' => $user->id]) }}" method="POST" style="display:inline;" onsubmit="return confirm('このユーザーをストアに復元しますか？');">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-info btn-sm">復元</button>
                                        </form>
                                    {{-- 管理ユーザーの場合 --}}
                                    @elseif($user->user_flg === 0)
                                        <form action="{{ route('user.flg', ['user' => $user->id]) }}" method="POST" style="display:inline;" onsubmit="return confirm('このユーザーを一般ユーザーにしますか？');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" style="background-color: orange; color: white; border: 1px solid orange; border-radius: 4px;" class="btn btn-outline-success btn-sm">一般ユーザーに変更</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection