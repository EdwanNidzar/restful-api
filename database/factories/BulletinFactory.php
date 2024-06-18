<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bulletin>
 */
class BulletinFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'page_count' => $this->faker->randomDigit,
            'cover_image' => $this->faker->imageUrl,
            'url_bulletin' => $this->faker->url,
            'status' => $this->faker->randomElement(['pending', 'approve', 'reject']),
            'release_status' => $this->faker->randomElement(['draft', 'published']),
            'notes' => $this->faker->sentence,
            'edition_id' => \App\Models\Edtion::factory(),
        ];
    }
}
