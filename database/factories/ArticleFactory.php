<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
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
            'title' => fake()->words(10, true),
            'subtitle' => fake()->words(5, true),
            'content' => fake()->words(255, true),
            'date' => fake()->date(),
            'time' => fake()->time(),
            'photo' => fake()->imageUrl(),
            'writer_id' => rand(1,10)

        ];
    }
}
