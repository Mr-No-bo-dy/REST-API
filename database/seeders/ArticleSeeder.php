<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryId = Category::where('name', 'Технології')->first()->id;

        Article::create([
            'title'        => 'Laravel 11 вже доступний',
            'description'      => 'Опис нових можливостей Laravel 11...',
            'author'       => 'Olena Kozak',
            'published_at' => now(),
            'category_id'  => $categoryId
        ]);

        Article::create([
            'title'        => 'PHP 8.3: що нового?',
            'description'      => 'Нове в синтаксисі та продуктивності...',
            'author'       => 'Oleksandr',
            'published_at' => now()->subDay(),
            'category_id'  => $categoryId
        ]);
    }
}
