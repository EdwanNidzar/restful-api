<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_date' => $this->faker->date(),
            'event_time' => $this->faker->time(),
            'event_name' => $this->faker->name(),
            'event_description' => $this->faker->text(),
            'event_location' => $this->faker->word(),
            'event_address' => $this->faker->word(),
            'event_image' => $this->faker->word(),
            'event_organization' => $this->faker->word(),
            'event_contact' => $this->faker->word(),
            'event_status' => $this->faker->randomElement(['upcoming', 'past', 'ongoing']),
            'submission_status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            'notes' => $this->faker->text(),
        ];
    }
}
