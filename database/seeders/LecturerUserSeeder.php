<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LecturerUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'lecturer@studentresult.test'],
            [
                'name' => 'Test Lecturer',
                'password' => Hash::make('Lecturer@12345'),
                'role' => 'lecturer',
                'email_verified_at' => now(),
            ]
        );
    }
}