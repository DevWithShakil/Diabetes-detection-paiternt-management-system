<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ✅ Admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // ✅ Doctor user
        User::create([
            'name' => 'Dr. Tareq Hasan',
            'email' => 'doctor@example.com',
            'password' => bcrypt('password'),
            'role' => 'doctor',
        ]);

        // ✅ Patient user (optional)
        User::create([
            'name' => 'Ruma Akter',
            'email' => 'patient@example.com',
            'password' => bcrypt('password'),
            'role' => 'patient',
        ]);
    }
}
