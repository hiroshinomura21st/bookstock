@extends('layouts.app')

@section('content')

<div class="d-flex suftify-content-center">
    <div class="row w-75">
        @if (session('flash_message'))
            <p>{{ session('flash_message') }}</p>
        @endif

        <div class="col-5 offset-1">
            @if ($book->image)
                <img src="{{ Strage::utl('img/' . $book->image) }}" class="img-fluidentity?token=1ad">
            @else
                <img src="{{ asset('img/dummy.png') }}" class="w-100 img-fluid">
            @endif
        </div>
        <div class="col">
            <div class="d-flex flex-column">
                <h1 class="">
                    {{$book->name}}
                </h1>
                <p class="">
                    {{$book->author}}
                </p>
                <hr>
                <p class="d-flex align-items-end">
                    出版年月日：{{$book->published_at}}
                </p>
                <hr>                
            </div>
            @auth
            <form method="POST" class="m-3 align-items-end">
                @csrf
                <div class="col-5">
                    @if (Auth::user()->favorite_books()->where('book_id', $book->id)->exists())
                        <a href="{{ route('favorites.destroy', $book->id) }}" class="btn bookstock-favorite-button text-favorite w-100" onclick="event.preventDefault(); document.getElementById('favorites-destroy-form').submit();">
                            <i class="fa fa-heart"></i>
                            お気に入り解除
                        </a><br><br>
                    @else
                        <a href="{{ route('favorites.store', $book->id) }}" class="btn bookstock-favorite-button text-favorite w-100" onclick="event.preventDefault(); document.getElementById('favorites-store-form').submit();">
                            <i class="fa fa-heart"></i>
                            お気に入り
                        </a><br><br>
                    @endif
                </div>
            </form>
                <div class="col-5">
                     @if ($book->user_id === Auth::id())
                        <a href="{{ route('books.edit', $book) }}" class="btn bookstock-favorite-button text-favorite w-50">
                            編集
                        </a><br><br>

                        <form action="{{ route('books.destroy', $book) }}" method="POST" onsubmit="return confirm('本当に削除してもよろしいですか？');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn bookstock-favorite-button text-favorite w-50">削除</button>
                        </form>
                    @endif
                </div>
            <form id="favorites-destroy-form" action="{{ route('favorites.destroy', $book->id) }}" method="POST" class="d-none">
                @csrf
                @method('DELETE')
            </form>
            <form id="favorites-store-form" action="{{ route('favorites.store', $book->id) }}" method="POST" class="d-none">
                @csrf
            </form>
            @endauth
        </div>

        <div class="offset-1 col-11">
            <hr class="w-100">
            <h3 class="float-left">読後感</h3>
        </div>

        <div class="offset-1 col-10">
            <div class="row">
                @foreach ($reviews as $review)
                    <div class="offset-md-5 col-md-5">
                        <h3 class="review-score-color">{{ str_repeat('★', $review->score) }}</h3>
                        <p class="h3">{{$review->content}}</p>
                        <label>{{$review->wrote_at}}</label>
                    </div>
                @endforeach
            </div><br />

            @auth
                <div class="row">
                    <div class="offset-md-5 col-md-5">
                        <form method="POST" action="{{ route('reviews.store') }}">
                            @csrf
                            <h4>評価</h4>
                            <select name="score" class="form-control m-2 review-score-color">
                                <option value="5" class="review-score-color">★★★★★</option>
                                <option value="4" class="review-score-color">★★★★</option>
                                <option value="3" class="review-score-color">★★★</option>
                                <option value="2" class="review-score-color">★★</option>
                                <option value="1" class="review-score-color">★</option>
                            </select>
                            <h4>感想</h4>
                            @error('content', 'wrote_at')
                                <strong>感想を入力してください</strong>
                            @enderror
                            <textarea name="content" class="form-control m-2"></textarea>
                            <input type="hidden" name="wrote_at" value="{{$book->wrote_at}}">
                            <input type="hidden" name="book_id" value="{{$book->id}}">
                            <button type="submit" class="btn bookstock-submit-button ml-2">感想を追加</button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</div>
    
@endsection