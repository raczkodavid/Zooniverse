<?php

namespace Database\Factories;

use App\Models\Animal;
use Illuminate\Database\Eloquent\Factories\Factory;
// use Animal module from faker

/**
 * @extends Factory<Animal>
 */
class AnimalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'species' => $this->faker->word(),
            'is_predator' => $this->faker->boolean(),
            'born_at' => $this->faker->dateTimeBetween('-10 years'),
        ];
    }
}
