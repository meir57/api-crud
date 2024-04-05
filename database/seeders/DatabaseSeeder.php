<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Meir',
            'email' => 'meirbek@meir.com',
            'password' => 'qwerty12345678',
        ]);

        User::factory()->create([
            'name' => 'User',
            'email' => 'user@meir.com',
            'password' => '123456789',
        ]);
    }
}
