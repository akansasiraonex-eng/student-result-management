<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RegistrarUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'registrar@studentresult.test'],
            [
                'name' => 'Test Registrar',
                'password' => Hash::make('Registrar@12345'),
                'role' => 'registrar',
                'email_verified_at' => now(),
            ]
        );
    }
}