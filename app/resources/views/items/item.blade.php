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
            <form action="{{ route('item.conf') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="form-group">
                <label for="images">商品画像(最大10枚)</label>

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
                <input type="text" class="form-control" id="itemname" name="itemname" value="{{ session('itemname', old('itemname')) }}" />
              </div>
              <br>
              <div class="form-group">
                <label for="price">金額</label>
                <input type="text" class="form-control" id="price" name="price" value="{{ session('price', old('price')) }}" />
              </div>
              <br>
              <div class="form-group">
                <label for="state">商品状態</label>
                <select name="state" id="state" class="form-control">
                    <option value="" disabled {{ session('state') === null && old('state') === null ? 'selected' : '' }}>選択してください</option>
                    @foreach ($states as $value => $label)
                        <option value="{{ $value }}" {{ session('state') == $value || old('state') == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
              </div>
              <br>
              <div class="form-group">
                <label for="presentation">商品説明</label>
                <textarea class="form-control" id="presentation" name="presentation" rows="3">{{ session('presentation', old('presentation')) }}</textarea>
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

      const sessionPreview = document.getElementById('session-preview');
      if (sessionPreview) {
        sessionPreview.classList.add('d-none');
      }
    
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
        img.style.width = '100px';
        img.style.height = '100px';
        preview.appendChild(img);
      }
      reader.readAsDataURL(file);
    });
  });
</script>
@endsection