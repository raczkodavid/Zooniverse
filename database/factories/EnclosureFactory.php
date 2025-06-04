<?php

namespace Database\Factories;

use App\Models\Enclosure;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Enclosure>
 */
class EnclosureFactory extends Factory
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
            'limit' => $this->faker->numberBetween(1, 100),
            'feeding_time' => $this->faker->time(),
        ];
    }
}
