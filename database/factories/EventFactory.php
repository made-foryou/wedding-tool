<?php

namespace Database\Factories;

use App\Domains\Guests\Models\GuestType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domains\Presence\Models\Event>
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
            'guest_type_id' => GuestType::factory(),
            'name' => $this->faker->words(),
            'location' => $this->faker->words(),
            'date' => $this->faker->date(),
            'start' => $this->faker->time(),
        ];
    }
}
