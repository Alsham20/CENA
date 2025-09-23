<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'author_id' => 1,
            'category' => fake()->numberBetween(1, 8),
            'poster' => 1,
            'is_published' => fake()->boolean(),
            'slug' => fake()->slug(),
            'publications_count' => 0,
            'content' => fake()->paragraphs(3, true),
            'content_keywords' => fake()->words(3, true),
            'content_description' => fake()->words(3, true),
            'tags' => fake()->words(3, true),
            'resume' => fake()->sentence(),

        ];
    }
}
