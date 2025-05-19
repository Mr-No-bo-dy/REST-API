<?php

namespace App\Http\Resources;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        /** @var Article $this */
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'author' => $this->author,
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name,
            ],
            'published_at' => optional($this->published_at)->toDateTimeString(),
        ];
    }
}
