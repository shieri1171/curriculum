@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col col-md-offset-3 col-md-6">
        <nav class="card mt-5">
          <div class="card-header text-center">商品 修正</div>
          <div class="card-body">
            @if($errors->any())
              <div class="alert alert-danger">
                @foreach($errors->all() as $message)
                  <p>{{ $message }}</p>
                @endforeach
              </div>
            @endif

            @if ($item->itemImages->count())
              <div class="mb-3">
                <p>登録済み画像：</p>
                <div class="row">
                  @foreach ($item->itemImages as $image)
                    <div class="col-md-3 mb-2">
                      <img src="{{ asset('storage/' . $image->image_path) }}" class="img-thumbnail" style="width:150px; height:150px; object-fit: cover;" alt="登録済み画像">
                      <form action="{{ route('item.image.delete', ['image' => $image->id]) }}" method="POST" onsubmit="return confirm('この画像を削除してもよろしいですか？');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm mt-2">削除</button>
                      </form>
                    </div>
                  @endforeach
                </div>
              </div>
            @endif

            <form action="{{ route('item.edit.conf', $item->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <input type="hidden" name="item_id" value="{{ $item->id }}">
              <div class="form-group">
                <label for="images">商品画像</label>
                
                <div id="session-preview" class="mt-3 d-flex flex-wrap">
                  @foreach (session('images', []) as $path)
                    <div class="m-1">
                      <img src="{{ asset('storage/' . $path) }}" class="img-thumbnail" style="width:150px; height:150px; object-fit: cover;">
                    </div>
                  @endforeach
                </div>

                <div id="preview" class="mt-3 d-flex flex-wrap"></div>
                <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*" />
              </div>
              <br>
              <div class="form-group">
                <label for="itemname">商品名</label>
                <input type="text" class="form-control" id="itemname" name="itemname" value="{{ session('itemname', old('itemname', $item['itemname'])) }}" />
              </div>
              <br>
              <div class="form-group">
                <label for="price">金額</label>
                <input type="text" class="form-control" id="price" name="price" value="{{ session('price', old('price', $item['price'])) }}" />
              </div>
              <br>
              <div class="form-group">
                <label for="state">商品状態</label>
                <select name="state" id="state" class="form-control">
                  <option value="" disabled {{ session('state') === null && old('state', $item->state ?? '') === null ? 'selected' : '' }}>選択してください</option>
                  @foreach ($states as $value => $label)
                    <option value="{{ $value }}" {{ session('state') == $value || old('state', $item->state ?? '') == $value ? 'selected' : '' }}>
                      {{ $label }}
                    </option>
                  @endforeach
                </select>
              </div>
              <br>
              <div class="form-group">
                <label for="presentation">商品説明</label>
                <textarea class="form-control" id="presentation" name="presentation" rows="3">{{ session('presentation', old('presentation', $item['presentation'])) }}</textarea>
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

  <script>
    document.getElementById('images').addEventListener('change', function(e) {
      const preview = document.getElementById('preview');
      preview.innerHTML = ''; 
      const files = e.target.files;
      
      if (files.length > 10) {
        alert('画像は10枚までです');
        e.target.value = ''; 
        return;
      }

      Array.from(files).forEach(file => {
        if (!file.type.match('image.*')) {
          return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
          const img = document.createElement('img');
          img.src = e.target.result;
          img.classList.add('img-thumbnail', 'm-1');
          img.style.width = '150px';
          img.style.height = '150px';
          img.style.objectFit = 'cover';
          preview.appendChild(img);
        }
        reader.readAsDataURL(file);
      });
    });
  </script>
@endsection