<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        /*\App\Models\User::factory()->create([
            'name' => 'Mario',
            'last_name' => 'Rossi',
            'date_of_birth' => '2000-12-12',
            'email' => 'mario@gmail.com',
        ]);*/

        $this->call([ServiceSeeder::class, UserSeeder::class, ApartmentSeeder::class]);
    }
}
