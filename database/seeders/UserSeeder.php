<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          // You can create multiple users
          User::factory(1)->create(); // Create 10 random users using the factory

          // Or create a single user manually
          User::create([
              'name' => 'Admin',
              'email' => 'support@viseTech.com',
              'password' => bcrypt('password123'), // Ensure to hash passwords
              'role' => 'Admin',
          ]);
    }
}
