<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Institute;
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
        $institute1 = Institute::create(['name' => 'Institute 1']);
        $institute2 = Institute::create(['name' => 'Institute 2']);
        $institute3 = Institute::create(['name' => 'Institute 3']);

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('12345678'),
            'role' => 'admin',
            'institute_id' => null,
        ]);

        $manager = User::factory()->create([
            'name' => 'Manager User',
            'email' => 'manager@test.com',
            'password' => bcrypt('12345678'),
            'role' => 'manager',
            'institute_id' => $institute1->id,
            'created_by' => $admin->id,
        ]);

        User::factory()->create([
            'name' => 'Employee User',
            'email' => 'employee@test.com',
            'password' => bcrypt('12345678'),
            'role' => 'employee',
            'institute_id' => $institute1->id,
            'created_by' => $manager->id,
        ]);

        foreach (['Laravel', 'PHP', 'JavaScript'] as $courseName) {
            Course::create([
                'institute_id' => $institute1->id,
                'course_name' => $courseName,
                'description' => null,
            ]);
        }

        Course::create([
            'institute_id' => $institute2->id,
            'course_name' => 'Web Design',
            'description' => null,
        ]);

        Course::create([
            'institute_id' => $institute3->id,
            'course_name' => 'Database Basics',
            'description' => null,
        ]);
    }
}
