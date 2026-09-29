<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'student@studentresult.test'],
            [
                'name' => 'Test Student',
                'password' => Hash::make('Student@12345'),
                'role' => 'student',
                'email_verified_at' => now(),
            ]
        );
    }
}