<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Biodata>
 */
class BiodataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->warga(),
            'tempat_lahir' => fake()->city(),
            'tanggal_lahir' => fake()->date(),
            'jenis_kelamin' => fake()->randomElement(['laki-laki', 'perempuan']),
            'Kebangsaan' => 'Indonesia',
            'agama' => fake()->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budah', 'Khonghucu']),
            'status_perkawinan' => fake()->randomElement(['Belum Kawin', 'Sudah Kawin', 'Bercerai']),
            'pendidikan' => fake()->randomElement(['SD', 'SMP', 'SMA', 'Diploma 1', 'Diploma 2', 'Diploma 3', 'Strata 1', 'Strata 2', 'Strata 3']),
            'alamat' => fake()->address(),
            'pekerjaan' => fake()->word(),
        ];
    }
}
