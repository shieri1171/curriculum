@extends('layout')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col col-md-offset-3 col-md-6">
        <nav class="card mt-5">
          <div class="card-header">メルカリへようこそ</div>
          <div class="card-body">
            @if($errors->any())
              <div class="alert alert-danger">
                @foreach($errors->all() as $message)
                  <p>{{ $message }}</p>
                @endforeach
              </div>
            @endif
            @foreach ($items as $item)
            <tr>
                <th scope="col">
                <a href="{{ route('item', ['item' => $item['id']]) }}">{{ $item->image }}</a>
                </th>
            </tr>
            @endforeach
          </div>
        </nav>
      </div>
    </div>
  </div>
@endsection