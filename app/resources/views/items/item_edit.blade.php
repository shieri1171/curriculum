@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col col-md-offset-3 col-md-6">
        <nav class="card mt-5">
          <div class="card-header text-center">出品</div>
          <div class="card-body">
            @if($errors->any())
              <div class="alert alert-danger">
                @foreach($errors->all() as $message)
                  <p>{{ $message }}</p>
                @endforeach
              </div>
            @endif
            <form action="{{ route('edit.item.conf', $item->id) }}" method="POST">
              @csrf
              <div class="form-group">
                <label for="images">商品画像(最大10枚)</label>
                <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*" />
              </div>
              <br>
              <div class="form-group">
                <label for="itemname">商品名</label>
                <input type="text" class="form-control" id="itemname" name="itemname" value="{{ old('itemname', $item['itemname']) }}" />
              </div>
              <br>
              <div class="form-group">
                <label for="price">金額</label>
                <input type="text" class="form-control" id="price" name="price" value="{{ old('price', $item['price']) }}" />
              </div>
              <br>
              <div class="form-group">
                <label for="state">商品状態</label>
                <select name="state" id="state" class="form-control">
                    <option value="{{ $item->state  }}" @selected(old('state', $item->state) == $item->id)>
                        {{ \App\Models\Item::ITEM_STATES[$item->state] }}
                    </option>
                    @foreach ($states as $value => $label)
                        <option value="{{ $value }}" {{ old('state', $item->state ?? '') == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
              </div>
              <br>
              <div class="form-group">
                <label for="presentation">商品説明</label>
                <input type="text" class="form-control" id="presentation" name="presentation" value="{{ old('presentation', $item['presentation']) }}" />
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