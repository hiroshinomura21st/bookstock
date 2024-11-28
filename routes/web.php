<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::resource('books', BookController::class);

Route::get('/', [BookController::class, 'index'])->middleware(['auth', 'verified'])->name('books.index');

/*
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
*/

require __DIR__.'/auth.php';

/*
Route::get('/books', [BookController::class, 'index'])->middleware(['auth', 'verified'])->name('books.index');

Route::get('/books/create', [BookController::class, 'create'])->middleware(['auth', 'verified'])->name('books.create');

Route::post('/books', [BookController::class, 'store'])->middleware(['auth', 'verified'])->name('books.store');

Route::get('/books/{book}', [BookController::class, 'show'])->middleware(['auth', 'verified'])->name('books.show');

Route::get('/books/{book}/edit', [BookController::class, 'edit'])->middleware(['auth', 'verified'])->name('books.edit');

Route::patch('/books/{book}', [BookController::class, 'update'])->middleware(['auth', 'verified'])->name('books.update');

Route::delte('/books/{book}', [BookController::class, 'destroy'])->middleware(['auth', 'verified'])->name('books.destroy');
*/

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('books', BookController::class);

    Route::post('reviews', [ReviewController::class, 'store'])->name('reviews.store');

    Route::post('favorites/{book_id}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('favorites/{book_id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

    Route::controller(UserController::class)->group(function () {
        Route::get('users/mypage', 'mypage')->name('mypage');
        Route::get('users/mypage/edit', 'edit')->name('mypage.edit');
        Route::put('users/mypage', 'update')->name('mypage.update');
        Route::get('users/mypage/password/edit', 'edit_password')->name('mypage.edit_password');
        Route::put('users/mypage/password', 'update_password')->name('mypage.update_password');
        Route::get('users/mypage/favorite', 'favorite')->name('mypage.favorite');
    });
});