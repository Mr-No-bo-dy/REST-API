<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var Category $this */
        // If needed even empty keys:
        return [
            'name' => $this->name,
            'sort_order' => $this->sort_order,
            'show_in_main_menu' => $this->show_in_main_menu ? 'yes' : 'no',
            'parent' => $this->parent_id
                ? [
                    'id' => $this->parent->id,
                    'name' => $this->parent->name,
                ]
                : null,
            'children' => $this->children->isNotEmpty()
                ? $this->children->map(fn($article) => [
                        'id' => $article->id,
                        'name' => $article->name,
                    ])->toArray()
                : [],
            'articles' => $this->articles->isNotEmpty()
                ? $this->articles->map(fn($article) => [
                        'id' => $article->id,
                        'title' => $article->title,
                        'author' => $article->author,
                    ])->toArray()
                : [],
        ];

        // If empty keys not needed:
//        return [
//            'name' => $this->name,
//            'sort_order' => $this->sort_order,
//            'show_in_main_menu' => $this->show_in_main_menu ? 'yes' : 'no',
//            ...($this->parent_id ? [
//                'parent' => [
//                    'id' => $this->parent->id,
//                    'name' => $this->parent->name,
//                ],
//            ] : []),
//            ...($this->children->isNotEmpty() ? [
//                'children' => $this->children->map(fn($article) => [
//                    'id' => $article->id,
//                    'name' => $article->name,
//                ])->toArray(),
//            ] : []),
//            ...($this->articles->isNotEmpty() ? [
//                'articles' => $this->articles->map(fn($article) => [
//                    'id' => $article->id,
//                    'title' => $article->title,
//                    'author' => $article->author,
//                ])->toArray(),
//            ] : []),
//        ];
    }
}
