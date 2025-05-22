<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\Category;
use App\Repositories\ArticleRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected ArticleRepository $repository;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = new ArticleRepository();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        // Our code
    }

    /* index() */
    public function test_all_returns_all_articles_with_category(): void
    {
        $count = 5;
        Article::factory($count)->create();

        $articles = $this->repository->all();

        $this->assertCount($count, $articles);
        foreach ($articles as $article) {
            $this->assertTrue($article->relationLoaded('category'));
            $this->assertInstanceOf(Category::class, $article->category);
        }
    }

    /* find() */
    public function test_find_returns_article_when_exists(): void
    {
        $article = Article::factory()->create();

        $found = $this->repository->find($article->id);

        $this->assertNotNull($found);
        $this->assertEquals($article->id, $found->id);
        $this->assertTrue($found->relationLoaded('category'));
    }

    public function test_find_returns_null_when_not_exists(): void
    {
        $found = $this->repository->find(999);

        $this->assertNull($found);
    }

    /* store() */
    public function test_store_creates_article_with_correct_data(): void
    {
        $category = Category::factory()->create();
        $data = [
            'title' => 'Sample Title',
            'description' => 'Sample description ...',
            'category_id' => $category->id,
            'author' => 'John Doe',
            'published_at' => '2025-05-16 15:25:35',
        ];

        $article = $this->repository->store($data);

        $this->assertEquals('Sample Title', $article->title);
        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'title' => 'Sample Title',
            'description' => 'Sample description ...',
            'category_id' => $category->id,
            'author' => 'John Doe',
            'published_at' => '2025-05-16 15:25:35',
        ]);
    }

    /* update() */
    public function test_update_updates_existing_article(): void
    {
        $article = Article::factory()->create([
            'title' => 'Old Title',
        ]);
        $data = ['title' => 'New Title'];

        $updated = $this->repository->update($data, $article->id);

        $this->assertNotNull($updated);
        $this->assertEquals('New Title', $updated->title);
        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'title' => 'New Title',
        ]);
    }

    public function test_update_returns_null_when_not_exists(): void
    {
        $updated = $this->repository->update(['title' => 'Does not matter'], 999);

        $this->assertNull($updated);
    }

    /* destroy() */
    public function test_destroy_deletes_article_when_exists(): void
    {
        $article = Article::factory()->create();

        $result = $this->repository->destroy($article->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('articles', ['id' => $article->id]);
    }

    public function test_destroy_returns_false_when_not_exists(): void
    {
        $result = $this->repository->destroy(999);

        $this->assertFalse($result);
    }
}
