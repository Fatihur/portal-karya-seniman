<?php

namespace App\Services\Dashboard;

use App\Enums\KaryaStatus;
use App\Models\Kategori;
use App\Models\KaryaSeni;
use App\Models\User;

class BuildAdminDashboardStats
{
    public function handle(): array
    {
        return [
            'totalSeniman' => User::where('peran', 'seniman')->where('status_akun', 'aktif')->count(),
            'totalKarya' => KaryaSeni::count(),
            'karyaMenunggu' => KaryaSeni::where('status_karya', KaryaStatus::Diajukan->value)->count(),
            'karyaPerluRevisi' => KaryaSeni::where('status_karya', KaryaStatus::PerluRevisi->value)->count(),
            'karyaDipublikasikan' => KaryaSeni::where('status_karya', KaryaStatus::Dipublikasikan->value)->count(),
            'kategoriAktif' => Kategori::where('status_aktif', true)->count(),
        ];
    }
}
