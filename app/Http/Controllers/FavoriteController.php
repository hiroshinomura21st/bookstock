<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function store($book_id)
    {
        Auth::user()->favorite_books()->attach($book_id);

        return back();
    }

    public function destroy($book_id)
    {
        Auth::user()->favorite_books()->detach($book_id);

        return back();
    }
}
