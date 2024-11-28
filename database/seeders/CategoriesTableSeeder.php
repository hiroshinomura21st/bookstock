<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $major_category_names = [
            '単行本', '新書・文庫', '雑誌'
        ];

        $large_size_book_categories = [
            '文学・評論', '人文・思想', '社会・政治･法律', 'ノンフィクション', 
            '歴史・地理', 'ビジネス・経済', '投資・金融・会社経営', '科学・テクノロジー', 
            '医学・薬学・看護学・歯科学', 'コンピュータ・IT', 'アート・建築・デザイン', 
            '趣味・実用', 'スポーツ・アウトドア', '資格・検定・就職', '暮らし・健康・子育て', 
            '旅行ガイド・マップ', '語学・辞事典・年鑑', '英語学習', '教育・学参・受験', 
            '絵本・児童書', 'コミック', 'ライトノベル', 'ボーイズラブ', 'タレント写真集', 
            'ゲーム攻略本', 'エンターテイメント'
        ];

        $small_size_book_categories = [
            '文学・評論', '人文・思想', '社会・政治･法律', 'ノンフィクション', 
            '歴史・地理', 'ビジネス・経済', '投資・金融・会社経営', '科学・テクノロジー', 
            '医学・薬学・看護学・歯科学', 'コンピュータ・IT', 'アート・建築・デザイン', 
            '趣味・実用', 'スポーツ・アウトドア', '資格・検定・就職', '暮らし・健康・子育て', 
            '旅行ガイド・マップ', '語学・辞事典・年鑑', '英語学習', '教育・学参・受験', 
            '絵本・児童書', 'コミック', 'ライトノベル', 'ボーイズラブ', 'タレント写真集', 
            'ゲーム攻略本', 'エンターテイメント'
        ];

        $magazine_categories = [
            '文学・評論', '人文・思想', '社会・政治･法律', 'ノンフィクション', 
            '歴史・地理', 'ビジネス・経済', '投資・金融・会社経営', '科学・テクノロジー', 
            '医学・薬学・看護学・歯科学', 'コンピュータ・IT', 'アート・建築・デザイン', 
            '趣味・実用', 'スポーツ・アウトドア', '資格・検定・就職', '暮らし・健康・子育て', 
            '旅行ガイド・マップ', '語学・辞事典・年鑑', '英語学習', '教育・学参・受験', 
            '絵本・児童書', 'コミック', 'ライトノベル', 'ボーイズラブ', 'タレント写真集', 
            'ゲーム攻略本', 'エンターテイメント'
        ];

        foreach ($major_category_names as $major_category_name) {
            if ($major_category_name == '単行本') {
                foreach ($large_size_book_categories as $large_size_book_category) {
                    Category::create([
                        'name' => $large_size_book_category,
                        'description' => $large_size_book_category,
                        'major_category_name' => $major_category_name
                    ]);
                }
            }

            if ($major_category_name == '新書・文庫') {
                foreach ($small_size_book_categories as $small_size_book_category) {
                    Category::create([
                        'name' => $small_size_book_category,
                        'description' => $small_size_book_category,
                        'major_category_name' => $major_category_name
                    ]);
                }
            }

            if ($major_category_name == '雑誌') {
                foreach ($magazine_categories as $magazine_category) {
                    Category::create([
                        'name' => $magazine_category,
                        'description' => $magazine_category,
                        'major_category_name' => $major_category_name
                    ]);
                }
            }
        }
    }
}
