<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => fake()->words(110, true),
            'date' => fake()->date(),
            'time' => fake()->time(),
            'user_id' => rand(1,11),
            'article_id' => rand(1,10)
        ];
    }
}
