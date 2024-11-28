@extends('layouts.app')

@section('content')

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error) 
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<div class="container">
    <h1>新しい書籍を追加</h1>

    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="book-name">書名</label>
            <input type="text" name="name" id="book-name" class="form-control">
        </div>
        <div class="form-group">
            <label for="book-author">著者名</label>
            <input type="text" name="author" id="book-author" class="form-control">
        </div>
        <div class="form-group">
            <label for="book-published_at">出版年月日</label>
            <input type="date" name="published_at" id="book-published_at" class="form-control">
        </div>
        <div class="form-group">
            <label for="book-image">画像アップロード</label>
            <input type="file" name="image" id="image">
        </div>
        <div class="form-group">
            <label for="book-category">カテゴリ</label>
            <select name="category_id" class="form-control" id="book-category">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">書籍を登録</button>
    </form>

    <a href="{{ route('books.index')}}">蔵書一覧に戻る</a>
</div>
    
@endsection
