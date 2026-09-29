<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Department;
use App\Models\Program;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'student@studentresult.test')->firstOrFail();

        $department = Department::firstOrCreate(
            ['code' => 'ICT'],
            [
                'name' => 'Information and Communication Technology',
                'description' => 'Department responsible for computing and information technology programmes.',
                'is_active' => true,
            ]
        );

        $program = Program::firstOrCreate(
            ['code' => 'BIT'],
            [
                'department_id' => $department->id,
                'name' => 'Bachelor of Information Technology',
                'award' => 'Bachelor Degree',
                'duration_years' => 4,
                'description' => 'A programme covering information technology, software development, databases and related computing disciplines.',
                'is_active' => true,
            ]
        );

        $academicYear = AcademicYear::firstOrCreate(
            ['name' => '2026/2027'],
            [
                'start_year' => 2026,
                'end_year' => 2027,
                'start_date' => '2026-08-01',
                'end_date' => '2027-07-31',
                'is_current' => true,
                'is_active' => true,
            ]
        );

        Student::updateOrCreate(
            ['user_id' => $user->id],
            [
                'program_id' => $program->id,
                'admission_academic_year_id' => $academicYear->id,
                'student_number' => 'STU001',
                'registration_number' => 'REG/2026/001',
                'first_name' => 'Test',
                'middle_name' => null,
                'last_name' => 'Student',
                'date_of_birth' => '2004-01-15',
                'gender' => 'Male',
                'nationality' => 'Ugandan',
                'phone' => null,
                'address' => null,
                'admission_date' => '2026-08-01',
                'status' => 'active',
            ]
        );
    }
}