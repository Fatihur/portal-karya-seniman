<?php

namespace Database\Factories;

use App\Models\ProfilSeniman;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfilSenimanFactory extends Factory
{
    protected $model = ProfilSeniman::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->seniman(),
            'nama_panggung' => fake()->name(),
            'foto_profil' => null,
            'foto_sampul' => null,
            'biografi' => fake()->paragraph(),
            'bidang_seni_utama' => fake()->randomElement(['Lukis', 'Tari', 'Musik', 'Patung']),
            'tanggal_lahir' => fake()->date(),
            'jenis_kelamin' => fake()->randomElement(['laki-laki', 'perempuan', 'lainnya']),
            'alamat' => fake()->address(),
            'kabupaten_kota' => fake()->city(),
            'provinsi' => 'Nusa Tenggara Barat',
            'instagram' => fake()->userName(),
            'facebook' => fake()->userName(),
            'youtube' => fake()->userName(),
            'situs_web' => fake()->url(),
            'prestasi' => fake()->sentence(),
        ];
    }
}
