<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Faq>
 */
class FaqFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question' => fake()->sentence(),
            'answer' => fake()->paragraphs(2, true),
            'category_id' => fake()->numberBetween(1, 8),
            'is_active' => fake()->boolean(),
            'position' => fake()->numberBetween(1, 10),
            'author_id' => 1,
            'order' => fake()->numberBetween(1, 100),
        ];
    }
}
