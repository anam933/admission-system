<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        // Create Manager User
        User::factory()->create([
            'name' => 'Manager User',
            'email' => 'manager@test.com',
            'password' => bcrypt('password123'),
            'role' => 'manager',
        ]);

        // Create Employee User
        User::factory()->create([
            'name' => 'Employee User',
            'email' => 'employee@test.com',
            'password' => bcrypt('password123'),
            'role' => 'employee',
        ]);
    }
}
