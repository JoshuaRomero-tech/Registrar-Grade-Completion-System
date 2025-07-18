<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\IncompleteGrade;
use App\Models\User;
use App\Models\Announcement;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a student user with the specified ID and password
        $student = User::create([
            'name' => 'John Doe',
            'id_number' => '22-2014-166',
            'email' => 'john.doe@example.com',
            'password' => Hash::make('Jeydicute1'),
            'role' => 'student',
        ]);
        
        // Create a dean user
        $dean = User::create([
            'name' => 'Dr. Jane Smith',
            'id_number' => 'DEAN-2025-001',
            'email' => 'jane.smith@example.com',
            'password' => Hash::make('password'),
            'role' => 'dean',
            'college' => 'College of Engineering',
        ]);
        
        // Create a faculty user
        $faculty = User::create([
            'name' => 'Prof. Robert Johnson',
            'id_number' => 'FAC-2025-001',
            'email' => 'robert.johnson@example.com',
            'password' => Hash::make('password'),
            'role' => 'faculty',
            'college' => 'College of Engineering',
        ]);

        // Create some courses and store their IDs
        $courseRecords = [];
        foreach ([
            [
                'code' => 'CS101',
                'title' => 'Introduction to Computer Science',
                'instructor_name' => 'FAC-2025-001',
                'college' => 'College of Engineering',
            ],
            [
                'code' => 'MATH202',
                'title' => 'Calculus II',
                'instructor_name' => 'FAC-2025-001',
                'college' => 'College of Engineering',
            ],
            [
                'code' => 'ENG110',
                'title' => 'English Composition',
                'instructor_name' => 'Dr. Williams',
                'college' => 'College of Liberal Arts',
            ],
        ] as $course) {
            $courseRecords[] = Course::create($course);
        }

        // Create some incomplete grades for the user using the actual course IDs
        $incompleteGrades = [
            [
                'user_id' => $student->id,
                'course_id' => $courseRecords[0]->id,
                'reason_for_incompleteness' => 'Missed final exam due to illness',
                'submission_deadline' => now()->addDays(30),
                'status' => 'Pending',
            ],
            [
                'user_id' => $student->id,
                'course_id' => $courseRecords[1]->id,
                'reason_for_incompleteness' => 'Incomplete project submission',
                'submission_deadline' => now()->addDays(15),
                'status' => 'Submitted',
            ],
            [
                'user_id' => $student->id,
                'course_id' => $courseRecords[2]->id,
                'reason_for_incompleteness' => 'Missing term paper',
                'submission_deadline' => now()->addDays(7),
                'status' => 'Pending',
            ],
        ];

        foreach ($incompleteGrades as $grade) {
            IncompleteGrade::create($grade);
        }

        // Always seed a test course and dean for announcement testing
        $this->call(AnnouncementTestSeeder::class);
    }
}
