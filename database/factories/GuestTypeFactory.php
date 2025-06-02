<?php

namespace Database\Factories;

use App\Domains\Guests\Models\GuestType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GuestType>
 */
class GuestTypeFactory extends Factory
{
    protected $model = GuestType::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
        ];
    }
}
