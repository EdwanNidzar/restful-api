<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'news_title' => $this->faker->sentence,
            'news_content' => $this->faker->paragraph,
            'news_image' => $this->faker->imageUrl(),
            'news_category' => $this->faker->word,
            'news_edition' => $this->faker->numberBetween(1, 10),
            'submission_status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            'notes' => $this->faker->sentence,
        ];
    }
}
