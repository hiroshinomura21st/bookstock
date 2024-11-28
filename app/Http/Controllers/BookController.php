<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use App\Models\Category;
use App\Models\MajorCategory;
use App\Http\Requests\BookRequest;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        
        if ($request->category !== null) {
            $books = Auth::user()->books()->where('category_id', $request->category)->sortable()->paginate(8);
            $total_count = Auth::user()->books()->where('category_id', $request->category)->count();
            $category = Category::find($request->category);
            $major_category = MajorCategory::find($category->major_category_id);
        } elseif ($keyword !== null) {
            $books = Auth::user()->books()->where('name', 'like', "%{$keyword}%")->sortable()->paginate(8);
            $total_count = $books->total();
            $category = null;
            $major_category = null;
        } else {
            $books = Auth::user()->books()->sortable()->paginate(8);
            $total_count = "";
            $category = null;
            $major_category = null;
        }
        
        $categories = Category::all();
        $major_categories = MajorCategory::all();

        return view('books.index', compact('books', 'category', 'major_category', 'categories', 'major_categories', 'total_count', 'keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        
        return view('books.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $request)
    {
        $book = new Book();
        $book->name = $request->input('name');
        $book->author = $request->input('author');
        $book->published_at = $request->input('published_at');
        $book->category_id = $request->input('category_id');
        $book->user_id = Auth::id();

        // 画像の保存とパスの設定
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/img');
            $book->image = basename($path);
        }
        
        $book->save();

        return redirect()->route('books.index')->with('flash_message', '登録が完了しました。');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        $reviews = $book->reviews()->get();
        
        return view('books.show', compact('book', 'reviews'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        if ($book->user_id !== Auth::id()) {
            return redirect()->route('books.index')->with('error_message', '不正なアクセスです。');
        }
        
        $categories = Category::all();

        return view('books.edit', compact('book', 'categories'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(BookRequest $request, Book $book)
    {
        if ($book->user_id !== Auth::id()) {
            return redirect()->route('books.index')->with('error_message', '不正なアクセスです。');
        }

        $book->name = $request->input('name');
        $book->author = $request->input('author');
        $book->published_at = $request->input('published_at');
        $book->category_id = $request->input('category_id');
        $book->update();

        return redirect()->route('books.show', $book)->with('flash_message', '書籍情報を編集しました。');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        if ($book->user_id !== Auth::id()) {
            return redirect()->route('books.index')->with('error_message', '不正なアクセスです');
        }

        $book->delete();

        return redirect()->route('books.index')->with('flash_message', '書籍情報を削除しました。');
    }
}
