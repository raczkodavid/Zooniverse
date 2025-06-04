<?php

namespace Database\Seeders;

use App\Models\Enclosure;
use App\Models\User;
use Illuminate\Database\Seeder;

class EnclosureSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		// create some enclosures and attach (1-5) caretakers to them
		$users = User::all();

		Enclosure::factory(10)->create()->each(function ($enclosure) use ($users) {
			$enclosure->users()->attach($users->random(rand(1, 5)));
		});
	}
}
