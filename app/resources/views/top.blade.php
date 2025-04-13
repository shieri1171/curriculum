@extends('layouts.layout')

@section('content')
  <div class="container text-center">
    <div class="row">
        <div class="display-1 mt-5 mb-5 w-100">メルカリへようこそ</div>

        <div class="row">
          @foreach ($items as $item)
            <div class="col-4 mb-4">
              <a href="{{ route('item.info', ['item' => $item->id]) }}">
                <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top rounded shadow" alt="{{ $item->name }}">
              </a>
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