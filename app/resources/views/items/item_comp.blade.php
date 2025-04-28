@extends('layouts.app')

@section('content')

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-12 col-md-6 mx-auto"> 
      <div class="card shadow-sm">
        <div class="card-header text-center">
          <h4 class="mb-0">出品が完了しました</h4>
        </div>
        <div class="card-body text-center">
            <a href="{{ route('item') }}" class="btn btn-primary">続けて出品</a>
            <a href="{{ route('top') }}" class="btn btn-primary">トップページへ</a>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection