<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Database\Seeder;

class LecturerProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'lecturer@studentresult.test')->firstOrFail();

        $department = Department::firstOrCreate(
            ['code' => 'ICT'],
            [
                'name' => 'Information and Communication Technology',
                'description' => 'Department responsible for computing and information technology programmes.',
                'is_active' => true,
            ]
        );

        Lecturer::updateOrCreate(
            ['user_id' => $user->id],
            [
                'department_id' => $department->id,
                'staff_number' => 'LEC001',
                'first_name' => 'Test',
                'middle_name' => null,
                'last_name' => 'Lecturer',
                'title' => 'Lecturer',
                'phone' => null,
                'specialization' => 'Information Technology',
                'employment_type' => 'full_time',
                'status' => 'active',
            ]
        );
    }
}