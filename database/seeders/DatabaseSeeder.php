<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 🔹 Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'roles' => 'admin',
        ]);

        // 🔹 TU Sekretariat
        User::create([
            'name' => 'TU Sekretariat',
            'email' => 'tusekre@example.com',
            'password' => Hash::make('password'),
            'roles' => 'tusekre',
        ]);

        // 🔹 TU Sekwan
        User::create([
            'name' => 'TU Sekwan',
            'email' => 'tusekwan@example.com',
            'password' => Hash::make('password'),
            'roles' => 'tusekwan',
        ]);

        // 🔹 Pimpinan
        User::create([
            'name' => 'Pimpinan DPRD',
            'email' => 'pimpinan@example.com',
            'password' => Hash::make('password'),
            'roles' => 'pimpinan',
        ]);

        // 🔹 Staff
        User::create([
            'name' => 'Staff DPRD',
            'email' => 'staff@example.com',
            'password' => Hash::make('password'),
            'roles' => 'staff',
        ]);
    }
}
