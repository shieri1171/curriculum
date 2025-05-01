@extends('layouts.managiment')

@section('content')
<div class="container text-center">
    <div class="row">
        <div class="display-1 mt-5 mb-5 w-100">商品一覧</div>
            @foreach ($items as $item)
                <div class="col-md-6 col-sm-12 mb-4"> 
                    <div class="border p-3 rounded d-flex justify-content-center align-items-center pt-4 mt-4">
                        <div class="d-flex align-items-center">
                            <div>
                                <img src="{{ asset('storage/' . $item->mainImage->image_path) }}" class="shadow-sm me-4" alt="商品画像" style="width: 140px; height: 140px;">
                            </div>

                            <div class="d-flex flex-column justify-content-between ms-3 flex-grow-1">
                                <div class="fw-bold">{{ $item->itemname }}</div>
                                <div class="fw-bold">
                                    <a href="{{ route('item.info', ['item' => $item->id]) }}" class="btn btn-secondary btn-sm">詳細へ</a>
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