<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Arsip>
 */
class ArsipFactory extends Factory
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
            'lokasi_file' => 'arsip/' . $this->faker->uuid() . '.pdf',
            'format_arsip' => $this->faker->randomElement(['pdf', 'docx', 'jpg']),
            'periode' => $this->faker->year(),
        ];
    }
}
