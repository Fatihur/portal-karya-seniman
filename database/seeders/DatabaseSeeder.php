<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kategori;
use App\Models\KataSambutan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'nama' => 'Administrator',
            'email' => 'admin@portalseniman.id',
            'nomor_hp' => '081234567890',
            'password' => Hash::make('password'),
            'peran' => 'admin',
            'status_akun' => 'aktif',
            'email_verified_at' => now(),
        ]);
        
        // Create Kategori
        $kategoriData = [
            ['nama_kategori' => 'Sejarah', 'slug' => 'sejarah'],
            ['nama_kategori' => 'Adat Istiadat', 'slug' => 'adat-istiadat'],
            ['nama_kategori' => 'Bahasa', 'slug' => 'bahasa'],
            ['nama_kategori' => 'Pakaian', 'slug' => 'pakaian'],
            ['nama_kategori' => 'Kesenian', 'slug' => 'kesenian'],
            ['nama_kategori' => 'Kuliner Tradisional', 'slug' => 'kuliner-tradisional'],
            ['nama_kategori' => 'Wisata Cagar Budaya', 'slug' => 'wisata-cagar-budaya'],
        ];
        
        foreach ($kategoriData as $kat) {
            Kategori::create($kat);
        }
        
        // Create Kata Sambutan
        KataSambutan::create([
            'judul' => 'Selamat Datang di Portal Karya Seniman',
            'nama_tokoh' => 'Kepala Dinas Kebudayaan',
            'jabatan' => 'Dinas Kebudayaan Kabupaten Sumbawa',
            'isi_sambutan' => 'Selamat datang di Portal Karya Seniman Budaya Sumbawa Besar. Portal ini menjadi wadah bagi para seniman untuk menampilkan karya-karya terbaik mereka dan berbagi kekayaan budaya Sumbawa kepada masyarakat luas.',
            'status_aktif' => true,
        ]);
        
        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin Email: admin@portalseniman.id');
        $this->command->info('Admin Password: password');
    }
}
