<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\User;
use App\Models\IncompleteGrade;
use Illuminate\Support\Facades\Hash;

class AnnouncementTestSeeder extends Seeder
{
    public function run(): void
    {
        $course = Course::firstOrCreate([
            'code' => 'TEST101',
        ], [
            'title' => 'Test Course',
            'instructor_name' => 'FAC-2025-001',
            'college' => 'Test College',
        ]);

        $user = User::firstOrCreate([
            'id_number' => 'DEAN-2025-001',
        ], [
            'name' => 'Test Dean',
            'email' => 'dean@example.com',
            'password' => Hash::make('password'),
            'role' => 'dean',
            'college' => 'Test College',
        ]);

        // Create a sample announcement with valid foreign keys
        \App\Models\Announcement::firstOrCreate([
            'course_id' => $course->id,
            'user_id' => $user->id,
            'title' => 'Test Announcement',
        ], [
            'body' => 'This is a test announcement.',
        ]);

        $student = User::firstOrCreate(
            ['email' => 'john.doe@example.com'],
            [
                'name' => 'John Doe',
                'id_number' => '22-2014-166',
                'password' => Hash::make('Jeydicute1'),
                'role' => 'student',
            ]
        );
    }
} 