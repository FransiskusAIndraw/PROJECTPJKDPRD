<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SuratMasuk>
 */
class SuratMasukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
             'no_surat' => strtoupper($this->faker->bothify('SM-###/###/2025')),
            'tgl_surat' => $this->faker->date(),
            'pengirim' => $this->faker->company(),
            'perihal' => $this->faker->sentence(4),
            'file_path' => 'uploads/surat/' . $this->faker->uuid() . '.pdf',
            'status_surat' => $this->faker->randomElement(['baru', 'diproses', 'selesai']),
        ];
    }
}
