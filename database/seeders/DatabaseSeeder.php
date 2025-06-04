<?php

namespace Database\Seeders;

use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{
		User::factory(10)->create();

		// create an admin user
		User::factory()->create([
			'name' => 'admin',
			'email' => 'admin@admin.com',
			'admin' => true,
			'password' => bcrypt('admin'),
		]);

		// create a normal user
		User::factory()->create([
			'name' => 'user',
			'email' => 'user@user.com',
			'password' => bcrypt('user'),
		]);

		// use other seeders
		$this->call([
			EnclosureSeeder::class,
			AnimalSeeder::class,
		]);
	}
}
