@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center mt-3">
    <div class="w-75">
        <h1>お気に入り</h1>

        <hr class="hy-4">

        @if ($favorite_books->isEmpty())
            <div class="row">
                <p class="mb-0">お気に入りはまだ追加されていません。</p>
            </div>
        @else
            <div class="row">
                @foreach ($favorite_books as $favorite_book)
                    <div class="col-md-7 mt-2">
                        <div class="d-inline-flex">
                            <a href="{{ route('books.show', $favorite_book->id) }}">
                                @if ($favorite_book->image !== "")
                                    <img src="{{ asset('storage/img/' . $favorite_book->image) }}" class="img-thumbnail bookstock-book-img-favorite">
                                @else
                                <img src="{{ asset('img/book05.jpg') }}" class="img-thumbnail bookstock-book-img-favorite">
                                @endif
                            </a>
                            <div class="container mt-3">
                                <h5 class="w-100 bookstock-favorite-item-text">{{ $favorite_book->name }}</h5>
                                <h6 class="w-100 bookstock-favorite-item-text">著者名：{{$favorite_book->author }}</h6>
                                <h6 class="w-100 bookstock-favorite-item-text">出版年月日：{{$favorite_book->published_at }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-center justify-content-end">
                        <a href="{{ route('favorites.destroy', $favorite_book->id) }}" class="bookstock-favorite-item-delete" onclick="event.preventDefault(); document.getElementById('favorites-destroy-form{{$favorite_book->id}}').submit();">
                            削除
                        </a>
                        <form id="favorites-destroy-form{{$favorite_book->id}}" action="{{ route('favorites.destroy', $favorite_book->id) }}" method="POST" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                @endforeach
            </div>    
        @endif

        <hr>
    </div>
</div>
@endsection