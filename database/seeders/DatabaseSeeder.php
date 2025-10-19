<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

// Import models
use App\Models\User;
use App\Models\SuratMasuk;
use App\Models\Disposisi;
use App\Models\Arsip;
use App\Models\LogAktivitas;
use App\Models\Notifikasi;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // === 1️⃣ Create Core Users ===
        User::create([
            'nama_lengkap' => 'Admin System',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'roles' => 'admin',
        ]);

        User::create([
            'nama_lengkap' => 'TU Sekwan',
            'email' => 'tusekwan@example.com',
            'password' => Hash::make('password'),
            'roles' => 'tusekwan',
        ]);

        User::create([
            'nama_lengkap' => 'TU Sekretariat',
            'email' => 'tusekre@example.com',
            'password' => Hash::make('password'),
            'roles' => 'tusekre',
        ]);

        User::create([
            'nama_lengkap' => 'Pimpinan DPRD',
            'email' => 'pimpinan@example.com',
            'password' => Hash::make('password'),
            'roles' => 'pimpinan',
        ]);

        User::create([
            'nama_lengkap' => 'Staff Sekretariat',
            'email' => 'staff@example.com',
            'password' => Hash::make('password'),
            'roles' => 'staff',
        ]);

        // Optional: generate 5 random users
        User::factory(5)->create();

        // === 2️⃣ Create Sample Surat Masuk ===
        SuratMasuk::factory(15)->create()->each(function ($surat) {
            // Attach related Arsip if factory exists
            if (class_exists(Arsip::class) && method_exists(Arsip::class, 'factory')) {
                Arsip::factory()->create([
                    'surat_masuk_id' => $surat->id,
                ]);
            }

            // Attach Disposisi if factory exists
            if (class_exists(Disposisi::class) && method_exists(Disposisi::class, 'factory')) {
                Disposisi::factory(rand(1, 2))->create([
                    'surat_masuk_id' => $surat->id,
                ]);
            }
        });

        // === 3️⃣ Optional Additional Seeds ===
        if (class_exists(LogAktivitas::class) && method_exists(LogAktivitas::class, 'factory')) {
            LogAktivitas::factory(20)->create();
        }

        if (class_exists(Notifikasi::class) && method_exists(Notifikasi::class, 'factory')) {
            Notifikasi::factory(20)->create();
        }

        $this->command->info('✅ Database seeding completed successfully!');
    }
}
