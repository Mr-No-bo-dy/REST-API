<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function authHeaders(): array
    {
        return [
            'Authorization' => 'Bearer ' . env('API_ACCESS_TOKEN'),
        ];
    }

    // -------- INDEX --------

    public function test_index_returns_unauthorized_without_token(): void
    {
        $response = $this->getJson(route('api.categories.index'));

        $response->assertStatus(401)
            ->assertJson([
                'error' => 'Unauthorized',
            ]);
    }

    public function test_index_returns_unauthorized_with_invalid_token(): void
    {
        $response = $this->getJson(route('api.categories.index'), [
            'Authorization' => 'Bearer ' . 'some_invalid_token',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'error' => 'Unauthorized',
            ]);
    }

    public function test_index_returns_new_collection(): void
    {
        Category::factory(5)->create();

        $response = $this->getJson(route('api.categories.index'), [
            'Authorization' => 'Bearer ' . env('API_ACCESS_TOKEN'),
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'name',
                        'sort_order',
                        'show_in_main_menu',
                        'parent',
                        'children',
                        'articles',
                    ]
                ],
            ]);
    }

    // -------- SHOW --------

    public function test_show_returns_category_when_exists(): void
    {
        $categoryParent = Category::factory()->create();
        $category = Category::factory()->create(['parent_id' => $categoryParent->id]);
        $article   = Article::factory()->for($category)->create();

        $response = $this->getJson(
            route('api.categories.show', $category->id),
            $this->authHeaders()
        );

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => $category->name,
                    'sort_order' => $category->sort_order,
                    'show_in_main_menu' => $category->show_in_main_menu,
                    'parent' => [
                        'id' => $category->parent->id,
                        'name' => $category->parent->name,
                    ],
                    'children' => [],
                    'articles' => [
                         [
                            'id' => $article->id,
                            'title' => $article->title,
                            'author' => $article->author,
                        ],
                    ],
                ],
            ]);
    }

    public function test_show_returns_404_when_not_exists(): void
    {
        $response = $this->getJson(
            route('api.categories.show', 999),
            $this->authHeaders()
        );

        $response->assertStatus(404)
            ->assertJson([
                'error' => 'Category not found',
            ]);
    }
}
