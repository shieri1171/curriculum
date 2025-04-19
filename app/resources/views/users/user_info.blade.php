@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col col-md-offset-3 col-md-6">
        <nav class="card mt-5">
          <div class="card-header text-center">購入者情報</div>
          <div class="card-body">
            @if($errors->any())
              <div class="alert alert-danger">
                @foreach($errors->all() as $message)
                  <p>{{ $message }}</p>
                @endforeach
              </div>
            @endif
            <form action="{{ route('buy.conf') }}" method="POST">
              @csrf
              <div class="form-group">
                <label for="name">氏名</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', session('name')) }}" />
              </div>
              <br>
              <div class="form-group">
                <label for="tel">電話番号</label>
                <input type="tel" pattern="\d*" class="form-control" id="tel" name="tel" value="{{ old('tel', session('tel')) }}" />
              </div>
              <br>
              <div class="form-group">
                <label for="postcode">郵便番号</label>
                <input type="tel" pattern="\d*" class="form-control" id="postcode" name="postcode" value="{{ old('postcode', session('postcode')) }}" />
              </div>
              <br>
              <div class="form-group">
                <label for="address">住所</label>
                <input type="text" class="form-control" id="address" name="address" value="{{ old('address', session('address')) }}" />
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