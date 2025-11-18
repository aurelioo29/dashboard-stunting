<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin untuk dashboard web
        User::updateOrCreate(
            ['email' => 'admin@estunt.com'],
            [
                'name'     => 'Admin e-Stunt',
                'password' => Hash::make('password123'),
                'role'     => 'admin',
            ]
        );

        // User biasa (untuk simulasi Flutter)
        User::updateOrCreate(
            ['email' => 'user@estunt.com'],
            [
                'name'     => 'User e-Stunt',
                'password' => Hash::make('password123'),
                'role'     => 'user',
            ]
        );
    }
}
