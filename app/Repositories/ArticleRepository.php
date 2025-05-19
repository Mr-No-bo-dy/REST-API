<?php

namespace App\Repositories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Collection;

class ArticleRepository
{
    public function all(): Collection
    {
        return Article::with('category')->get();
        // return Article::with('category')->paginate(3);    // paginated
    }

    public function find(int $id): ?Article
    {
        return Article::with('category')->find($id);
    }

    public function store(array $data): Article
    {
        return Article::create($data);
    }

    public function update(array $data, int $id): ?Article
    {
        $article = Article::find($id);
        if ($article) {
            $article->update($data);
        }

        return $article;
    }

    public function destroy(int $id): bool
    {
        return Article::destroy($id) > 0;
    }
}
