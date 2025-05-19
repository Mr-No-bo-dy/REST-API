<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository
{
    public function all(): Collection
    {
        return Category::with([
            'parent',
            'children',
            'articles',
        ])
            ->orderBy('sort_order')
            ->get();
    }

    public function find(int $id): ?Category
    {
        return Category::with([
            'parent',
            'children',
            'articles',
        ])
            ->find($id);
    }

}
