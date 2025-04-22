@extends('layouts.layout')

@section('content')
  <div class="container text-center">
    <div class="row">
        @if (session('message'))
            <div class="alert alert-warning">
                {{ session('message') }}
            </div>
        @endif
        <div class="display-1 mt-5 mb-5 w-100">メルカリへようこそ</div>

        <div class="row">
          @foreach ($items as $item)
            <div class="col-4 mb-4">
              <a href="{{ route('item.info', ['item' => $item->id]) }}">
                @if ($item->mainImage)
                  <img src="{{ asset('storage/' . $item->mainImage->image_path) }}" class="card-img-top rounded shadow" alt="{{ $item->name }}">
                @else
                  <img src="{{ asset('path/to/default/image.jpg') }}" class="card-img-top rounded shadow" alt="デフォルト画像">
                @endif              </a>
            </div>

            @if ($loop->iteration % 3 == 0 && !$loop->last)
              </div><div class="row"> 
            @endif
          @endforeach
        </div>
      </div>
    </div>
  </div>
@endsection