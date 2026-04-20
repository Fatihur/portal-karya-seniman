<?php

namespace Database\Factories;

use App\Models\KaryaSeni;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class KaryaSeniFactory extends Factory
{
    protected $model = KaryaSeni::class;

    public function definition(): array
    {
        $title = fake()->unique()->sentence(3);

        return [
            'user_id' => User::factory()->seniman(),
            'kategori_id' => Kategori::factory(),
            'judul_karya' => $title,
            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(1000, 9999),
            'deskripsi_singkat' => fake()->sentence(),
            'deskripsi_lengkap' => fake()->paragraph(),
            'tahun_karya' => '2024',
            'media_karya' => 'Akrilik',
            'dimensi' => '100 x 100 cm',
            'lokasi_asal' => 'Sumbawa Besar',
            'thumbnail' => 'karya/thumbnails/default.webp',
            'status_karya' => 'draft',
            'catatan_admin_terbaru' => null,
            'diajukan_pada' => null,
            'disetujui_pada' => null,
            'dipublikasikan_pada' => null,
            'jumlah_dilihat' => 0,
            'status_aktif' => true,
        ];
    }

    public function draft(): static
    {
        return $this->state(fn () => ['status_karya' => 'draft']);
    }

    public function diajukan(): static
    {
        return $this->state(fn () => [
            'status_karya' => 'diajukan',
            'diajukan_pada' => now(),
        ]);
    }

    public function perluRevisi(): static
    {
        return $this->state(fn () => [
            'status_karya' => 'perlu_revisi',
            'diajukan_pada' => now()->subDay(),
        ]);
    }

    public function dipublikasikan(): static
    {
        return $this->state(fn () => [
            'status_karya' => 'dipublikasikan',
            'diajukan_pada' => now()->subDays(2),
            'disetujui_pada' => now()->subDay(),
            'dipublikasikan_pada' => now()->subDay(),
        ]);
    }
}
