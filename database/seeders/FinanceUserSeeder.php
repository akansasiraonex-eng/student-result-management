<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FinanceUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'finance@studentresult.test'],
            [
                'name' => 'Test Finance Officer',
                'password' => Hash::make('Finance@12345'),
                'role' => 'finance',
                'email_verified_at' => now(),
            ]
        );
    }
}