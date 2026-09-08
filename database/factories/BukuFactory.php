<?php

namespace Database\Factories;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class BukuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'judul' => fake()->sentence(3),
            'penulis' => fake()->name(),
            'kategori' => fake()->randomElement([
                'Pendidikan',
                'Novel',
                'Komik',
                'Filsafat',
                'Bisnis'
            ]),
            'stok' => fake()->numberBetween(1, 5),
            'deskripsi' => fake()->paragraph(),
        ];
    }
}
