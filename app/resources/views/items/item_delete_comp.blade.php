@extends('layouts.app')

@section('content')

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow-sm">
        <div class="card-header text-center">
          <h4 class="mb-0">削除が完了しました</h4>
        </div>
        <div class="card-body text-center">
            <a href="{{ route('top') }}" class="btn btn-primary">トップページへ</a>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection