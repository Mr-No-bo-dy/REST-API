<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

class CategoryResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="CategoryResource",
     *     type="object",
     *     title="Category Resource",
     *     @OA\Property(property="name", type="string", example="Technology"),
     *     @OA\Property(property="sort_order", type="integer", example=1),
     *     @OA\Property(property="show_in_main_menu", type="boolean", example=true),
     *     @OA\Property(
     *          property="parent",
     *          type="object",
     *          @OA\Property(property="id", type="integer", example=1),
     *          @OA\Property(property="name", type="string", example="Category name"),
     *     ),
     *     @OA\Property(
     *          property="children",
     *          type="array",
     *          @OA\Items(
     *              type="object",
     *              @OA\Property(property="id", type="integer", example=1),
     *              @OA\Property(property="name", type="string", example="Category name"),
     *          ),
     *     ),
     *      @OA\Property(
     *           property="articles",
     *           type="array",
     *           @OA\Items(
     *               type="object",
     *               @OA\Property(property="id", type="integer", example=1),
     *               @OA\Property(property="title", type="string", example="Article title"),
     *               @OA\Property(property="author", type="string", example="Olaksandr"),
     *           ),
     *      ),
     * ),
     */
    public function toArray(Request $request): array
    {
        /** @var Category $this */
        // If needed even empty keys:
        return [
            'name' => $this->name,
            'sort_order' => $this->sort_order,
            'show_in_main_menu' => (bool)$this->show_in_main_menu,
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
//            'show_in_main_menu' => (bool)$this->show_in_main_menu,
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
