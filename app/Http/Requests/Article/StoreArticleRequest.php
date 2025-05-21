<?php

namespace App\Http\Requests\Article;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="StoreArticleRequest",
 *     required={"title", "description", "category_id", "author", "published_at"},
 *     @OA\Property(property="title", type="string", maxLength=255, example="Breaking News Title"),
 *     @OA\Property(property="description", type="string", maxLength=1024, example="This is the content of the news."),
 *     @OA\Property(property="category_id", type="integer", example=1),
 *     @OA\Property(property="author", type="string", maxLength=255, example="John Doe"),
 *     @OA\Property(property="published_at", type="string", format="date", example="2025-05-19"),
 * ),
 */
class StoreArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string','max:1024'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'author' => ['required', 'string', 'max:255'],
            'published_at' => ['required', 'date'],
        ];
    }
}
