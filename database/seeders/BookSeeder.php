<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // BookFactoryクラスで定義した内容にもとづいてダミーデータを25個生成し、booksテーブルに追加する
        Book::factory()->count(25)->create();
    }
}
