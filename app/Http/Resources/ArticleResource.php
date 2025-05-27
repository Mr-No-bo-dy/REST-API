<?php

namespace App\Http\Resources;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

class ArticleResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="ArticleResource",
     *     type="object",
     *     title="Article Resource",
     *     @OA\Property(property="id", type="integer", example=1),
     *     @OA\Property(property="title", type="string", example="Breaking News Title"),
     *     @OA\Property(property="description", type="string", example="This is the content of the news."),
     *     @OA\Property(property="author", type="string", maxLength=255, example="John Doe"),
     *     @OA\Property(
     *          property="category",
     *          type="object",
     *          @OA\Property(property="id", type="integer", example=1),
     *          @OA\Property(property="name", type="string", example="Category name"),
     *     ),
     *     @OA\Property(property="published_at", type="string", format="date", example="2025-05-19 00:00:00"),
     * ),
     */
    public function toArray(Request $request): array
    {
        /** @var Article $this */
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'author' => $this->author,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'published_at' => optional($this->published_at)->toDateTimeString(),
        ];
    }
}
