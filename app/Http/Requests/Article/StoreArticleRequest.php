<?php

namespace App\Http\Requests\Article;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

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
