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

        <div class="row row-cols-3 row-cols-md-3 row-cols-xl-5">
          @foreach ($items as $item)
            <div class="col mb-4">
              <a href="{{ route('item.info', ['item' => $item->id]) }}" class="text-decoration-none text-dark">
                <div class="card h-100 shadow-sm d-flex flex-column">
                  <div class="ratio ratio-1x1">
                    <img src="{{ asset('storage/' . $item->mainImage->image_path) }}" class="card-img-top object-fit-cover rounded-top" alt="{{ $item->itemname }}">
                  </div>
                  <hr class="my-0">
                  <div class="card-body d-flex flex-column">
                    <h5 class="card-title mb-0 fs-6">{{ $item->itemname }}</h5>
                    <p class="card-text text-primary fw-bold mt-auto">￥{{ number_format($item->price) }}</p>
                  </div>
                </div>
              </a>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
@endsection