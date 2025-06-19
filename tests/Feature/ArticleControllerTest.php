<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
	use RefreshDatabase;    // reset  DB between tests

	// Imitate Authorization
	protected function authHeaders(): array
	{
		return [
			'Authorization' => 'Bearer ' . env('API_ACCESS_TOKEN'),
		];
	}

	// -------- INDEX --------

    public function test_index_returns_unauthorized_without_token(): void
    {
        $response = $this->getJson(route('articles.index'));

        $response->assertStatus(401)
            ->assertJson([
                'error' => 'Unauthorized',
            ]);
    }

    public function test_index_returns_unauthorized_with_invalid_token(): void
    {
        $response = $this->getJson(route('articles.index'), [
            'Authorization' => 'Bearer ' . 'some_invalid_token',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'error' => 'Unauthorized',
            ]);
    }

    public function test_index_returns_new_collection(): void
    {
        Article::factory(5)->create();

        $response = $this->getJson(route('articles.index'), [
            'Authorization' => 'Bearer ' . env('API_ACCESS_TOKEN'),     // it's taken from phpunit.xml
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'description',
                        'author',
                        'published_at',
                        'category',
                    ]
                ],
            ]);
    }

	// -------- SHOW --------

	public function test_show_returns_article_when_exists(): void
	{
		$category = Category::factory()->create();
		$article  = Article::factory()->for($category)->create();

		$response = $this->getJson(
			route('articles.show', $article->id),
			$this->authHeaders()
		);

		$response->assertStatus(200)
			->assertJson([
				'data' => [
					'id'           => $article->id,
					'title'        => $article->title,
					'description'  => $article->description,
					'author'       => $article->author,
					'category'     => [
                        'name' => $category->name,
                        'sort_order' => $category->sort_order,
                        'show_in_main_menu' => $category->show_in_main_menu,
					],
					'published_at' => $article->published_at->toDateTimeString(),
				],
			]);
	}

	public function test_show_returns_404_when_not_exists(): void
	{
		$response = $this->getJson(
			route('articles.show', 999),
			$this->authHeaders()
		);

		$response->assertStatus(404)
			->assertJson([
				'error' => 'Article not found',
			]);
	}

	// -------- STORE --------

	public function test_store_creates_and_returns_new_article_with_correct_data(): void
	{
		$category = Category::factory()->create();

		$data = [
			'title'        => 'New title',
			'description'  => 'Some description',
			'author'       => 'Oleksandr',
			'category_id'  => $category->id,
			'published_at' => now()->toDateTimeString(),
		];

		$response = $this->postJson(
			route('articles.store'),
			$data,
			$this->authHeaders()
		);

		$response->assertStatus(201)
			->assertJsonStructure(['data' => ['id', 'title', 'description', 'author', 'category', 'published_at']])
			->assertJson([
				'data' => [
					'title'       => 'New title',
					'author'      => 'Oleksandr',
					'category'    => [
						'name' => $category->name,
                        'sort_order' => $category->sort_order,
                        'show_in_main_menu' => $category->show_in_main_menu,
					],
					'published_at' => $data['published_at'],
				],
			]);

		$this->assertDatabaseHas('articles', [
			'title'       => 'New title',
			'author'      => 'Oleksandr',
			'description'  => 'Some description',
			'category_id' => $category->id,
			'published_at' => $data['published_at'],
		]);
		$response->assertSee($data['title']);
		$response->assertSee($data['description']);
		$response->assertSee($data['category_id']);
		$response->assertSee($data['author']);
		$response->assertSee($data['published_at']);
	}

	// -------- UPDATE --------

	public function test_update_changes_and_returns_article_with_correct_data(): void
	{
		$category1 = Category::factory()->create();
		$category2 = Category::factory()->create();
		$article   = Article::factory()->for($category1)->create([
			'title' => 'Old',
		]);
		$data = [
			'title'        => 'Updated',
			'description'  => 'Changed desc',
			'author'       => 'Bob',
			'category_id'  => $category2->id,
			'published_at' => now()->toDateTimeString(),
		];

		$response = $this->putJson(
			route('articles.update', $article->id),
			$data,
			$this->authHeaders()
		);

		$response->assertStatus(200)
			->assertJson([
				'data' => [
					'id'    => $article->id,
					'title' => 'Updated',
					'author'=> 'Bob',
					'category' => [
                        'name' => $category2->name,
                        'sort_order' => $category2->sort_order,
                        'show_in_main_menu' => $category2->show_in_main_menu,
					],
					'published_at' => $data['published_at'],
				],
			]);

		$this->assertDatabaseHas('articles', [
			'id'          => $article->id,
			'title'       => 'Updated',
			'description'  => 'Changed desc',
			'category_id' => $category2->id,
			'author'=> 'Bob',
			'published_at' => $data['published_at'],
		]);
	}

	public function test_update_returns_404_when_not_exists(): void
	{
		$response = $this->putJson(
			route('articles.update', 999),
			['title' => 'Does not matter'],
			$this->authHeaders()
		);

		$response->assertStatus(404)
			->assertJson(['error' => 'Article not updated']);
	}

	// -------- DESTROY --------

	public function test_destroy_deletes_and_returns_message(): void
	{
		$article = Article::factory()->create();

		$response = $this->deleteJson(
			route('articles.destroy', $article->id),
			[],
			$this->authHeaders()
		);

		$response->assertStatus(200)
			->assertJson(['message' => 'Article has been deleted']);

		$this->assertDatabaseMissing('articles', ['id' => $article->id]);
	}

	public function test_destroy_returns_404_when_not_exists(): void
	{
		$response = $this->deleteJson(
			route('articles.destroy', 999),
			[],
			$this->authHeaders()
		);

		$response->assertStatus(404)
			->assertJson(['error' => 'Article not found']);
	}
}
