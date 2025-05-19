<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tech = Category::create([
            'name'              => 'Технології',
            'sort_order'        => 1,
            'show_in_main_menu' => true,
        ]);

        $sport = Category::create([
            'name'              => 'Спорт',
            'sort_order'        => 2,
            'show_in_main_menu' => true,
        ]);

        Category::create([
            'name'              => 'Гаджети',
            'parent_id'         => $tech->id,
            'sort_order'        => 1,
            'show_in_main_menu' => false,
        ]);

        Category::create([
            'name'              => 'Футбол',
            'parent_id'         => $sport->id,
            'sort_order'        => 1,
            'show_in_main_menu' => false,
        ]);
    }
}
