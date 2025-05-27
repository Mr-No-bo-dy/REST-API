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
        return [
            'name' => $this->name,
            'sort_order' => $this->sort_order,
            'show_in_main_menu' => (bool)$this->show_in_main_menu,
            'parent' => new CategoryResource($this->whenLoaded('parent')),
            'children' => CategoryResource::collection($this->whenLoaded('children')),
            'articles' => ArticleResource::collection($this->whenLoaded('articles')),
        ];
    }
}
