<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kategori;
use App\Models\ProfilPortal;
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
            ['nama_kategori' => 'Sejarah', 'slug' => 'sejarah', 'urutan' => 1, 'ikon' => 'bi-book'],
            ['nama_kategori' => 'Adat Istiadat', 'slug' => 'adat-istiadat', 'urutan' => 2, 'ikon' => 'bi-people'],
            ['nama_kategori' => 'Bahasa', 'slug' => 'bahasa', 'urutan' => 3, 'ikon' => 'bi-chat-square-text'],
            ['nama_kategori' => 'Pakaian', 'slug' => 'pakaian', 'urutan' => 4, 'ikon' => 'bi-person-bounding-box'],
            ['nama_kategori' => 'Kesenian', 'slug' => 'kesenian', 'urutan' => 5, 'ikon' => 'bi-music-note-beamed'],
            ['nama_kategori' => 'Kuliner Tradisional', 'slug' => 'kuliner-tradisional', 'urutan' => 6, 'ikon' => 'bi-cup-hot'],
            ['nama_kategori' => 'Wisata Cagar Budaya', 'slug' => 'wisata-cagar-budaya', 'urutan' => 7, 'ikon' => 'bi-geo-alt'],
        ];
        
        foreach ($kategoriData as $kat) {
            Kategori::create($kat);
        }
        
        // Create Profil Portal
        ProfilPortal::create([
            'nama_portal' => 'Portal Karya Seniman Budaya Sumbawa Besar',
            'sejarah' => 'Portal ini didirikan untuk mendokumentasikan dan melestarikan karya seni budaya dari Sumbawa Besar.',
            'visi' => 'Menjadi pusat dokumentasi karya seniman budaya Sumbawa Besar yang terpercaya dan terkurasi.',
            'misi' => 'Mendokumentasikan karya seni, mempromosikan seniman lokal, dan melestarikan budaya Sumbawa.',
            'alamat' => 'Jl. Budaya No. 1, Sumbawa Besar, Nusa Tenggara Barat',
            'email_kontak' => 'info@portalseniman.id',
            'telepon' => '(0371) 123456',
            'instagram' => '@portalseniman.sumbawa',
            'facebook' => 'Portal Seniman Sumbawa',
        ]);
        
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
