@extends('layouts.app')

@section('content')

@if (session('flash_message'))
    <p>{{ session('flash_message') }}</p>
@endif

@if (session('error_message'))
    <p>{{ session('error_message') }}</p>
@endif

<a href="{{ route('books.create') }}">新規登録</a>

<div class="row">
    <div class="col-2">
        @component('components.sidebar', ['categories' => $categories, 'major_category_names' => $major_category_names])                
        @endcomponent
    </div>
    <div class="col-9">
        <div class="container">
            @if ($category !== null)
                <a href="{{ route('books.index') }}">トップ</a> > <a href="#">{{ $category->major_category_name }}</a> {{ $category->name }}
                <h1>{{ $category->name }}の書籍一覧{{$total_count}}件</h1>
            @elseif ($keyword !== null)
                <a href="{{ route('books.index')}}">トップ</a> > 商品一覧
                <h1>"{{ $keyword }}"の検索結果{{$total_count}}件</h1>
            @endif
        </div>
        <div>
            Sort By
            @sortablelink('name', '書名')
            @sortablelink('author', '著者名')
        </div>
        <div class="container mt-4">
                
            @if ($books->isNotEmpty())
                <div class="row w-100">
                    @foreach ($books as $book)
                    <div class="col-3">
                        <a href="{{route('books.show', $book)}}">
                            @if ($book->image !== "")
                                <img src="{{ Storage::url('img/' . $book->image) }}" class="img-fluidentity?token=1ad">
                            @else
                                <img src="{{ asset('img/dummy.png') }}" class="img-thumbnail">
                            @endif
                        </a>
                        <div class="row">
                            <div class="col-12">
                                <p class="bookstock-book-label mt-2">
                                    {{$book->name}}<br>
                                    <span>著者名：{{$book->author}}</span><br>
                                    <span>出版年月日：{{ $book->published_at }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p>書籍が登録されていません。</p>
            @endif
        </div>
        {{ $books->appends(request()->query())->links() }}
    </div>
</div>

@endsection