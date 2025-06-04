<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\Enclosure;
use Illuminate\Database\Seeder;

class AnimalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $enclosures = Enclosure::all();

        foreach ($enclosures as $enclosure) {
            $animalsToCreate = rand(1, $enclosure->limit);

            // create the first animal
            $animal = Animal::factory()->for($enclosure)->create();
            $isPredatorEnclosure = $animal->is_predator;

            // Create the remaining animals while ensuring compatibility
            for ($i = 1; $i < $animalsToCreate; $i++) {
                Animal::factory()->for($enclosure)->create([
                    'is_predator' => $isPredatorEnclosure,
                ]);
            }
        }
    }
}
