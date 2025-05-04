@extends('layouts.managiment')

@section('content')
<div class="container text-center">
    <div class="row">
        <div class="display-1 mt-5 mb-5 w-100">商品一覧</div>
            <table>
                <tr>
                    <th>メイン画像</th>
                    <th>他画像</th>
                    <th>商品名</th>
                    <th>価格</th>
                    <th>商品状態</th>
                    <th>商品説明</th>
                    <th>詳細へ</th>
                    <th>削除⇔復元</th>
                </tr>
                @foreach ($items as $item)
                    <tr>
                        <td>
                            <img src="{{ asset('storage/' . $item->mainImage->image_path) }}" class="shadow-sm me-4" alt="商品画像" style="width: 40px; height: 40px;">
                        </td>
                        <td>
                            @if($item->itemImages->count() >= 2)
                                有
                            @endif
                        </td>
                        <td>{{ $item->itemname }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->state }}</td>
                        <td>{{ $item->presentation }}</td>
                        <td>
                            <a href="{{ route('item.info', ['item' => $item->id]) }}" class="btn btn-secondary btn-sm">詳細へ</a>
                        </td>
                        <td>
                            @if($item->del_flg === 0)
                                <form action="{{ route('item.delflg', ['item' => $item->id]) }}" method="POST" style="display:inline;" onsubmit="return confirm('この商品をストアから削除してもよろしいですか？');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">削除</button>
                                </form>
                            @else
                                <form action="{{ route('item.restore', ['item' => $item->id]) }}" method="POST" style="display:inline;" onsubmit="return confirm('この商品をストアに復元しますか？');">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">復元</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>

@endsection