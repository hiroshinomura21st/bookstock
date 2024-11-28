<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Book;

class BookTest extends TestCase
{
    use RefreshDatabase;

    // 未ログインのユーザーは書籍一覧ページにアクセスできない
    public function test_guest_cannot_access_books_index()
    {
        $response = $this->get(route('books.index'));

        $response->assertRedirect(route('login'));
    }

    // ログイン済みのユーザーは書籍一覧ページにアクセスできる
    public function test_user_can_access_books_index()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('books.index'));

        $response->assertStatus(200);
        $response->assertSee($book->name);
    }

    // 未ログインのユーザーは書籍詳細ページにアクセスできない
    public function test_guest_cannot_access_books_show()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['user_id' => $user->id]);

        $response = $this->get(route('books.show', $book));

        $response->assertRedirect(route('login'));
    }

    // ログイン済みのユーザーは書籍詳細ページにアクセスできる
    public function test_user_can_access_books_show()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('books.show', $book));

        $response->assertStatus(200);
        $response->assertSee($book->name);
    }

    // 未ログインのユーザーは新規登録ページにアクセスできない
    public function test_guest_cannot_access_books_create()
    {
        $response = $this->get(route('books.create'));

        $response->assertRedirect(route('login'));
    }

    // ログイン済みのユーザーは新規登録ページにアクセスできる
    public function test_user_can_access_books_create()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('books.create'));

        $response->assertStatus(200);
    }

    // 未ログインのユーザーは登録を作成できない
    public function test_guest_cannot_access_books_store()
    {
        $book = [
            'name' => 'PHP本格入門上',
            'author' => '大家正登',
            'published_at' => '2020-08-15',
            'category_id' => 10
        ];

        $response = $this->post(route('books.store'), $book);

        $this->assertDatabaseMissing('books', $book);
        $response->assertRedirect(route('login'));
    }

    // ログイン済みのユーザーは登録を作成できる
    public function test_user_can_access_books_store()
    {
        $user = User::factory()->create();

        $book = [
            'name' => 'PHP本格入門上',
            'author' => '大家正登',
            'published_at' => '2020-08-15',
            'category_id' => 10
        ];

        $response = $this->actingAs($user)->post(route('books.store'), $book);
 
        $this->assertDatabaseHas('books', $book);
        $response->assertRedirect(route('books.index'));
    }

    // 未ログインのユーザーは書籍情報編集ページにアクセスできない
    public function test_guest_cannot_access_books_edit()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['user_id' => $user->id]);

        $response = $this->get(route('books.edit', $book));

        $response->assertRedirect(route('login'));
    }

    // ログイン済みのユーザーは他人の書籍情報編集ページにアクセスできない
    public function test_user_cannot_access_others_books_edit()
    {
        $user = User::factory()->create();
        $other_user = User::factory()->create();
        $others_book = Book::factory()->create(['user_id' => $other_user->id]);

        $response = $this->actingAs($user)->get(route('books.edit', $others_book));

        $response->assertRedirect(route('books.index'));
    }

    // ログイン済みのユーザーは自身の書籍情報編集ページにアクセスできる
    public function test_user_can_access_own_books_edit()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('books.edit', $book));

        $response->assertStatus(200);
    }

    // 未ログインのユーザーは書籍情報を更新できない
    public function test_guest_cannot_update_book()
    {
        $user = User::factory()->create();
        $old_book = Book::factory()->create(['user_id' => $user->id]);

        $new_book = [
            'name' => 'PHP本格入門上',
            'author' => '大家正登',
            'published_at' => '2020-08-15',
            'category_id' => 10
        ];

        $response = $this->patch(route('books.update', $old_book), $new_book);

        $this->assertDatabaseMissing('books', $new_book);
        $response->assertRedirect(route('login'));
    }

    // ログイン済みのユーザーは他人の書籍情報を更新できない
    public function test_guest_cannot_update_others_book()
    {
        $user = User::factory()->create();
        $other_user = User::factory()->create();
        $others_old_book = Book::factory()->create(['user_id' => $other_user->id]);

        $new_book = [
            'name' => 'PHP本格入門上',
            'author' => '大家正登',
            'published_at' => '2020-08-15',
            'category_id' => 10
        ];

        $response = $this->actingAs($user)->patch(route('books.update', $others_old_book), $new_book);

        $this->assertDatabaseMissing('books', $new_book);
        $response->assertRedirect(route('books.index'));
    }

    // ログイン済みのユーザーは自身の書籍情報を更新できる
    public function test_user_can_update_own_book()
    {
        $user = User::factory()->create();
        $old_book = Book::factory()->create(['user_id' => $user->id]);

        $new_book = [
            'name' => 'PHP本格入門上',
            'author' => '大家正登',
            'published_at' => '2020-08-15',
            'category_id' => 10
        ];

        $response = $this->actingAs($user)->patch(route('books.update', $old_book), $new_book);

        $this->assertDatabaseHas('books', $new_book);
        $response->assertRedirect(route('books.show', $old_book));
    }

    // 未ログインのユーザーは書籍情報を削除できない
    public function test_guest_cannot_destroy_book()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['user_id' => $user->id]);

        $response = $this->delete(route('books.destroy', $book));

        $this->assertDatabaseHas('books', ['id' => $book->id]);
        $response->assertRedirect(route('login'));
    }

    // ログイン済みのユーザーは他人の投稿を削除できない
    public function test_user_cannot_destroy_others_book()
    {
        $user = User::factory()->create();
        $other_user = User::factory()->create();
        $others_book = Book::factory()->create(['user_id' => $other_user->id]);

        $response = $this->actingAs($user)->delete(route('books.destroy', $others_book));

        $this->assertDatabaseHas('books', ['id' => $others_book->id]);
        $response->assertRedirect(route('books.index'));
    }

    // ログイン済みのユーザーは自身の書籍情報を削除できる
    public function test_user_can_destroy_own_book()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('books.destroy', $book));

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
        $response->assertRedirect(route('books.index'));
    }
}
