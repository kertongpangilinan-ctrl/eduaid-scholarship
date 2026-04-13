<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Batch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user if not exists
        User::firstOrCreate(
            ['email' => 'EduAid@gmail.com'],
            [
                'name' => 'Admin User',
                'username' => 'admin',
                'password' => Hash::make('EduAid-SDK2026'),
                'role' => 'admin',
                'account_status' => 'approved',
                'email_verified_at' => now(),
            ]
        );

        // Create sample batch if not exists
        Batch::firstOrCreate(
            ['batch_number' => 1, 'academic_year' => '2025-2026'],
            [
                'status' => 'active',
                'start_date' => now(),
                'end_date' => now()->addYear(),
            ]
        );
    }
}
