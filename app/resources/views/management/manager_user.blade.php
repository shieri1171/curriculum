@extends('layouts.managiment')

@section('content')
<div class="container text-center">
    <div class="row">
        <div class="display-1 mt-5 mb-5 w-100">ユーザー一覧</div>
            <table>
                <tr>
                    <th>アイコン</th>
                    <th>ユーザー名</th>
                    <th>メールアドレス</th>
                    <th>プロフ文</th>
                    <th>氏名</th>
                    <th>電話番号</th>
                    <th>郵便番号</th>
                    <th>住所</th>
                    <th>ユーザー区分</th>
                    <th>削除⇔復元</th>
                </tr>
                @foreach ($users as $user)
                    <tr>
                        <td>
                            <img src="{{ asset('storage/' . $user->image) }}" class="rounded-circle me-4" alt="ユーザー画像" style="width: 40px; height: 40px;">
                        </td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->profile }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->tel }}</td>
                        <td>{{ $user->postcode }}</td>
                        <td>{{ $user->address }}</td>

                        <td>
                            @if($user->user_flg === 1)
                                <form action="{{ route('user.flg', ['user' => $user->id]) }}" method="POST" style="display:inline;" onsubmit="return confirm('このユーザーを管理ユーザーにしますか？');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" style="background-color: white; color: orange; border: 1px solid orange; border-radius: 4px;" class="btn btn-outline-success btn-sm">管理者に</button>
                                </form>
                            @elseif($user->user_flg === 0)
                                <form action="{{ route('user.flg', ['user' => $user->id]) }}" method="POST" style="display:inline;" onsubmit="return confirm('このユーザーを一般ユーザーにしますか？');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" style="background-color: orange; color: white; border: 1px solid orange; border-radius: 4px;" class="btn btn-outline-success btn-sm">ユーザーに</button>
                                </form>
                            @endif
                        </td>
                        <td>
                            @if($user->user_flg == 1 && $user->del_flg == 0)
                                <form action="{{ route('user.delflg', ['user' => $user->id]) }}" method="POST" style="display:inline;" onsubmit="return confirm('このユーザーを利用停止にしてもよろしいですか？');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">停止</button>
                                </form>
                            @elseif($user->user_flg == 1 && $user->del_flg == 1)
                                <form action="{{ route('user.restore', ['user_id' => $user->id]) }}" method="POST" style="display:inline;" onsubmit="return confirm('このユーザーをストアに復元しますか？');">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-info btn-sm">復元</button>
                                </form>
                            @else
                                管理者
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection