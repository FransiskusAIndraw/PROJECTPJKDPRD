<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        \App\Models\User::factory()->create([
        'nama_lengkap' => 'Admin System',
        'email' => 'admin@example.com',
        'password' => Hash::make('password'),
        'roles' => 'admin',
        ]);

         // Create additional users
    \App\Models\User::factory(10)->create();

    // Create fake surat masuk with relationships
    \App\Models\SuratMasuk::factory(20)
        ->has(\App\Models\Disposisi::factory(2))
        ->has(\App\Models\Arsip::factory(1))
        ->create();

    // Add logs and notifications
    \App\Models\LogAktivitas::factory(30)->create();
    \App\Models\Notifikasi::factory(30)->create();
    }
}
