<?php

namespace Database\Factories;

use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class KategoriFactory extends Factory
{
    protected $model = Kategori::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);

        return [
            'nama_kategori' => Str::title($name),
            'slug' => Str::slug($name),
            'deskripsi' => fake()->sentence(),
            'ikon' => 'bi bi-palette',
            'gambar' => null,
            'urutan' => fake()->numberBetween(1, 20),
            'status_aktif' => true,
        ];
    }

    public function nonaktif(): static
    {
        return $this->state(fn () => ['status_aktif' => false]);
    }
}
