<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Disposisi>
 */
class DisposisiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'surat_id' => \App\Models\SuratMasuk::factory(),
            'dari_user' => \App\Models\User::factory(),
            'ke_user' => \App\Models\User::factory(),
            'instruksi' => $this->faker->sentence(),
            'tgl_disposisi' => $this->faker->dateTimeThisYear(),
            'status_dispo' => $this->faker->randomElement(['baru', 'diteruskan', 'selesai']),
        ];
    }
}
