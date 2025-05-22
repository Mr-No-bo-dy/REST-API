<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'sort_order' => rand(0, 10),
            'parent_id' => null,
            'show_in_main_menu' => $this->faker->boolean(),
        ];
    }

    public function withParent(): self
    {
        return $this->state(function () {
            return [
                'parent_id' => Category::factory(),
            ];
        });
    }
}
