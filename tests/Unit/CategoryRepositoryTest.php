<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected CategoryRepository $repository;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = new CategoryRepository();
    }

    /* index() */
    public function test_all_returns_all_categories_with_category(): void
    {
        $count = 5;
        Category::factory($count)->create();

        $categories = $this->repository->all();

        $this->assertCount($count, $categories);
        foreach ($categories as $category) {
            $this->assertTrue($category->relationLoaded('parent'));
            $this->assertTrue($category->relationLoaded('children'));
            $this->assertTrue($category->relationLoaded('articles'));
            if ($category->parent) $this->assertInstanceOf(Category::class, $category->parent);
            foreach ($category->children as $child) {
                $this->assertInstanceOf(Category::class, $child);
            }
            foreach ($category->articles as $article) {
                $this->assertInstanceOf(Article::class, $article);
            }
        }
    }

    /* find() */
    public function test_find_returns_category_when_exists(): void
    {
        $category = Category::factory()->create();

        $found = $this->repository->find($category->id);

        $this->assertNotNull($found);
        $this->assertEquals($category->id, $found->id);
        $this->assertTrue($found->relationLoaded('parent'));
        $this->assertTrue($found->relationLoaded('children'));
        $this->assertTrue($found->relationLoaded('articles'));
        if ($category->parent) $this->assertInstanceOf(Category::class, $category->parent);
        foreach ($category->children as $child) {
            $this->assertInstanceOf(Category::class, $child);
        }
        foreach ($category->articles as $article) {
            $this->assertInstanceOf(Article::class, $article);
        }
    }

    public function test_find_returns_null_when_not_exists(): void
    {
        $found = $this->repository->find(999);

        $this->assertNull($found);
    }
}
